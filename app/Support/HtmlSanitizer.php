<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;

/**
 * Sanitizer HTML minimal khusus untuk hasil rich text editor (Bold/Italic/
 * Underline) pada isi berita.
 *
 * Sengaja TIDAK memakai paket eksternal (mis. HTMLPurifier) supaya tidak
 * menambah dependency baru ke composer.json — daftar tag yang diperbolehkan
 * dibuat sangat ketat (whitelist), karena ini satu-satunya tempat "HTML dari
 * input admin" dirender balik ke halaman publik lewat {!! !!}.
 *
 * Aturan:
 * - Hanya tag di ALLOWED_TAGS yang dipertahankan sebagai elemen HTML.
 * - SEMUA atribut dibuang, dengan SATU pengecualian: rata teks (left/center/
 *   right/justify) pada <p>/<li>. Nilainya dibaca lalu ditulis ulang dari
 *   whitelist, bukan disalin — onclick, style lain, href javascript:, dst
 *   tetap tidak pernah bisa lolos. Tag <a> tidak dipakai sama sekali.
 * - Tag di luar whitelist dilepas, tapi teks di dalamnya tetap dipertahankan
 *   supaya isi berita tidak hilang saat disunting dari editor lama/HTML asing.
 * - Tag di STRIP_CONTENT_TAGS (script/style/iframe/dst) dibuang beserta ISI
 *   di dalamnya.
 */
class HtmlSanitizer
{
    private const ALLOWED_TAGS = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'ul', 'ol', 'li'];

    /** Tag coret varian lama/bawaan browser -> dinormalkan jadi <s>. */
    private const STRIKE_ALIASES = ['strike', 'del'];

    /** Elemen blok yang boleh membawa rata teks (hasil tombol rata kiri/tengah/kanan/penuh). */
    private const ALIGNABLE_TAGS = ['p', 'li'];

    private const ALLOWED_ALIGN = ['left', 'center', 'right', 'justify'];

    /** Tag blok: kalau <div> mengandung salah satunya, <div> dilepas saja (bukan dijadikan <p>). */
    private const BLOCK_TAGS = ['p', 'div', 'ul', 'ol', 'li'];

    private const STRIP_CONTENT_TAGS = ['script', 'style', 'iframe', 'object', 'embed', 'noscript'];

    public static function clean(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<?xml encoding="utf-8"?><div>'.$html.'</div>',
            LIBXML_NOERROR | LIBXML_NOWARNING
        );
        libxml_clear_errors();

        $root = $dom->getElementsByTagName('div')->item(0);
        if (! $root) {
            return e(strip_tags($html));
        }

        $out = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $out .= self::renderNode($child);
        }

        return $out;
    }

    private static function renderNode(DOMNode $node): string
    {
        if ($node instanceof DOMText) {
            return htmlspecialchars($node->wholeText, ENT_QUOTES, 'UTF-8');
        }

        if (! $node instanceof DOMElement) {
            return '';
        }

        $tag = strtolower($node->tagName);

        if (in_array($tag, self::STRIP_CONTENT_TAGS, true)) {
            return '';
        }

        $inner = '';
        foreach (iterator_to_array($node->childNodes) as $child) {
            $inner .= self::renderNode($child);
        }

        if (in_array($tag, self::STRIKE_ALIASES, true)) {
            $tag = 's';
        }

        // Browser (execCommand) kadang membungkus baris dengan <div> alih-alih
        // <p>. <div> yang isinya hanya teks/inline dijadikan <p> supaya jeda
        // paragraf & rata teksnya tidak hilang; <div> pembungkus blok lain
        // cukup dilepas.
        if ($tag === 'div' && ! self::hasBlockChild($node)) {
            $tag = 'p';
        }

        if (! in_array($tag, self::ALLOWED_TAGS, true)) {
            // Tag tidak diizinkan (mis. <div> pembungkus, <span>, <a>, <img>)
            // — buang tag-nya saja, teks di dalamnya tetap tampil.
            return $inner;
        }

        if ($tag === 'br') {
            return '<br>';
        }

        // Satu-satunya "atribut" yang dipertahankan: rata teks pada <p>/<li>.
        // Nilainya TIDAK disalin dari input — hanya dibaca, dicocokkan dengan
        // whitelist, lalu ditulis ulang oleh kita sendiri, jadi tidak ada
        // celah menyelundupkan CSS/JS lewat atribut style.
        $align = in_array($tag, self::ALIGNABLE_TAGS, true) ? self::readAlign($node) : null;
        if ($align !== null) {
            return "<{$tag} style=\"text-align:{$align}\">{$inner}</{$tag}>";
        }

        return "<{$tag}>{$inner}</{$tag}>";
    }

    private static function hasBlockChild(DOMElement $node): bool
    {
        foreach ($node->childNodes as $child) {
            if ($child instanceof DOMElement && in_array(strtolower($child->tagName), self::BLOCK_TAGS, true)) {
                return true;
            }
        }

        return false;
    }

    /** Baca rata teks dari style="text-align:..." atau align="..." lalu validasi ke whitelist. */
    private static function readAlign(DOMElement $node): ?string
    {
        $candidate = null;

        if (preg_match('/text-align\s*:\s*([a-z-]+)/i', $node->getAttribute('style'), $m)) {
            $candidate = strtolower($m[1]);
        } elseif ($node->hasAttribute('align')) {
            $candidate = strtolower(trim($node->getAttribute('align')));
        }

        // "left" adalah bawaan, tidak perlu ditulis.
        if ($candidate === null || $candidate === 'left') {
            return null;
        }

        return in_array($candidate, self::ALLOWED_ALIGN, true) ? $candidate : null;
    }
}
