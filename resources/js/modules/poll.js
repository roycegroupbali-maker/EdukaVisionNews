/* Widget jajak pendapat pembaca (voting sederhana, disimpan di memori) */
export function initPoll() {
  const pollOptions = document.querySelectorAll('.poll-option');
  if (!pollOptions.length) return;

  let pollVoted = false;
  const pollBase = { opt1: 520, opt2: 341, opt3: 266, opt4: 157 };

  pollOptions.forEach((opt) => {
    opt.addEventListener('click', () => {
      if (pollVoted) return;
      pollVoted = true;

      const chosen = opt.getAttribute('data-opt');
      pollBase[chosen] += 1;

      let total = 0;
      Object.keys(pollBase).forEach((k) => (total += pollBase[k]));

      pollOptions.forEach((o) => {
        const key = o.getAttribute('data-opt');
        const pct = Math.round((pollBase[key] / total) * 100);
        o.querySelector('.poll-fill').style.width = pct + '%';
        o.querySelector('.poll-pct').textContent = pct + '%';
        o.classList.add('voted');
      });

      const totalEl = document.getElementById('pollTotal');
      const noteEl = document.getElementById('pollNote');
      if (totalEl) totalEl.textContent = total.toLocaleString('id-ID');
      if (noteEl) noteEl.textContent = 'Terima kasih, suaramu sudah tercatat.';
    });
  });
}
