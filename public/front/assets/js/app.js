{
    const e = () => {
        document.documentElement.style.setProperty("--body-scroll-width", window.innerWidth - document.documentElement.clientWidth + "px")
    };
    window.addEventListener("resize", e), e()
} {
    const e = () => {
            setDarkMode(!isDarkMode());
            const e = isDarkMode();
            localStorage.setItem("darkMode", e ? "1" : "0")
        },
        t = e => {
            e.checked = isDarkMode()
        };
    document.querySelectorAll("[data-darkmode-toggle] input, [data-darkmode-switch] input").forEach((n => {
        n.addEventListener("change", e), t(n)
    }))
}
document.querySelectorAll(".uc-horizontal-scroll").forEach((e => {
    e.addEventListener("wheel", (t => {
        t.preventDefault(), e.scrollBy({
            left: t.deltaY,
            behavior: "smooth"
        })
    }))
})), document.addEventListener("DOMContentLoaded", (() => {
    const e = document.querySelector("[data-uc-backtotop]");
    if (!e) return;
    e.addEventListener("click", (e => {
        e.preventDefault(), window.scrollTo({
            top: 0,
            behavior: "smooth"
        })
    }));
    let t = 0;
    window.addEventListener("scroll", (() => {
        const n = document.body.getBoundingClientRect().top;
        e.parentNode.classList.toggle("uc-active", n <= t), t = n
    }))
})), document.addEventListener("DOMContentLoaded", (function() {
    let e = [].slice.call(document.querySelectorAll("video.video-lazyload"));

    function t(e) {
        let t = e.querySelector("source");
        t.src = t.dataset.src, e.load(), e.muted = !0, "visible" === document.visibilityState ? e.play() : document.addEventListener("visibilitychange", (function t() {
            "visible" === document.visibilityState && (e.play(), document.removeEventListener("visibilitychange", t))
        }))
    }
    if ("IntersectionObserver" in window) {
        let n = new IntersectionObserver((function(e, o) {
            e.forEach((function(e) {
                if (e.isIntersecting) {
                    let o = e.target;
                    t(o), n.unobserve(o)
                }
            }))
        }));
        e.forEach((function(e) {
            n.observe(e), e.getBoundingClientRect().top < window.innerHeight && e.getBoundingClientRect().bottom > 0 && (t(e), n.unobserve(e))
        }))
    } else e.forEach((function(e) {
        t(e)
    }))
}));
   
  /***** CONFIG (CSV public Google Sheets) *****/
  const CSV_URL =
    "https://docs.google.com/spreadsheets/d/e/2PACX-1vSiesy4405xHOj2DsnPDnwQ9Dj3mDtgF0V-ClSM6VYvK5Zrnx67xJbU4VmNDQxFcFASQDwa-3xRSxVK/pub?gid=2030710409&single=true&output=csv";

  /* Load Google Charts dynamically */
  function loadScript(src) { return new Promise((res, rej) => { const s = document.createElement('script'); s.src = src; s.onload = res; s.onerror = () => rej(new Error('load ' + src)); document.head.appendChild(s); }); }

  window.addEventListener('load', async () => {
    // load google charts then init
    await loadScript("https://www.gstatic.com/charts/loader.js");
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(init);
  });

  /* ================== Utilities ================== */
  function parseCSV(text) {
    const lines = text.replace(/\r/g, '').split('\n').filter(l => l.trim().length);
    return lines.map(l => {
      const out = []; let cur = '', inQ = false;
      for (let i = 0; i < l.length; i++) {
        const ch = l[i];
        if (ch === '"') { inQ = !inQ; continue; }
        if (ch === ',' && !inQ) { out.push(cur); cur = ''; continue; }
        cur += ch;
      }
      out.push(cur);
      return out.map(v => v === '' ? null : v);
    });
  }
  const mean = arr => { const x = arr.filter(v => typeof v === 'number' && !isNaN(v)); return x.length ? x.reduce((a, b) => a + b, 0) / x.length : 0; };
  function parseFrDatetime(s) {
    if (!s) return null;
    const m = s.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})(?:\s+(\d{1,2}):(\d{2})(?::(\d{2}))?)?/);
    if (m) {
      const d = Number(m[1]), mo = Number(m[2]) - 1, y = Number(m[3]);
      const hh = Number(m[4] || 0), mm = Number(m[5] || 0), ss = Number(m[6] || 0);
      return new Date(y, mo, d, hh, mm, ss);
    }
    const dt = new Date(s);
    return isNaN(dt) ? null : dt;
  }
  function esc(s) { return (s || "").replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;"); }
  function norm(v) {
    return (v ?? "")
      .toString()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/\s+/g, ' ')
      .replace(/\u00A0/g, ' ')
      .trim().toLowerCase();
  }

  function parseLikert(v) {
    if (v == null) return null;
    if (typeof v === 'number') {
      const n = Math.round(v);
      return (n >= 1 && n <= 5) ? n : null;
    }
    const s = String(v).replace(/\u00A0/g, ' ').trim();
    const n1 = Number(s.replace(',', '.'));
    if (!isNaN(n1) && n1 >= 1 && n1 <= 5 && Math.abs(n1 - Math.round(n1)) < 1e-9) {
      return Math.round(n1);
    }
    const m = s.match(/(^|\D)([1-5])(\D|$)/);
    if (m) return Number(m[2]);
    return null;
  }

  function colorForMean(v) {
    if (v <= 2) return '#ef4444';
    if (v <= 4) return '#f59e0b';
    if (v <= 4.5) return '#86efac';
    if (v >= 4.6) return '#16a34a';
    return '#86efac';
  }

  /* gradient palettes by criterion */
  const CRITERION_BASE = {
    obj: '#2563eb', support: '#7c3aed', aide: '#f59e0b',
    rythme: '#06b6d4', formateur: '#ec4899', reco: '#16a34a'
  };
  function hexToRgb(hex) { const m = hex.replace('#', '').match(/^([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i); if (!m) return { r: 0, g: 0, b: 0 }; return { r: parseInt(m[1], 16), g: parseInt(m[2], 16), b: parseInt(m[3], 16) }; }
  function rgbToHex({ r, g, b }) { const h = n => Math.max(0, Math.min(255, Math.round(n))).toString(16).padStart(2, '0'); return `#${h(r)}${h(g)}${h(b)}`; }
  function mixRgb(a, b, t) { return { r: a.r * (1 - t) + b.r * t, g: a.g * (1 - t) + b.g * t, b: a.b * (1 - t) + b.b * t }; }
  function shadeScale(baseHex) { const base = hexToRgb(baseHex), white = { r: 255, g: 255, b: 255 }, black = { r: 0, g: 0, b: 0 }; return [rgbToHex(mixRgb(base, white, 0.60)), rgbToHex(mixRgb(base, white, 0.35)), rgbToHex(base), rgbToHex(mixRgb(base, black, 0.20)), rgbToHex(mixRgb(base, black, 0.35))]; }
  const CRITERION_COLORS = {
    obj: shadeScale(CRITERION_BASE.obj),
    support: shadeScale(CRITERION_BASE.support),
    aide: shadeScale(CRITERION_BASE.aide),
    rythme: shadeScale(CRITERION_BASE.rythme),
    formateur: shadeScale(CRITERION_BASE.formateur),
    reco: shadeScale(CRITERION_BASE.reco)
  };

  function toTitleCaseFr(str) {
    if (!str) return '';
    const s = String(str).toLowerCase();
    return s.replace(/(^|[\s\-’'\/])([a-zà-ÿœæ])/g, (_, p1, p2) => p1 + p2.toUpperCase());
  }

  /* ========= Data storage ========= */
  let rows = [], headers = [];
  let filtered = [];

  function colLike(exact, keyword = "") {
    let idx = headers.indexOf(exact);
    if (idx !== -1) return idx;
    const needle = (keyword || exact || "").toLowerCase().trim();
    idx = headers.findIndex(h => (h || "").toLowerCase().includes(needle));
    return idx;
  }

  function guessCommentsIndex(data, usedIdxs = new Set()) {
    const isDateLike = (s) => !!parseFrDatetime(s);
    const isNumeric = (s) => !isNaN(Number(s)) && s !== null && s !== '';
    const scoreCol = (j) => {
      let score = 0, hits = 0;
      for (let i = 0; i < Math.min(data.length, 300); i++) {
        const v = (data[i][j] ?? '').toString();
        const len = v.trim().length;
        if (!len) continue;
        if (isNumeric(v) || isDateLike(v)) continue;
        const bonus = (/\s/.test(v) ? 2 : 1) + (/[.,;:!?]/.test(v) ? 1 : 0);
        score += len * bonus; hits++;
      }
      if (hits < 3) score *= 0.1;
      return score;
    };
    let best = -1, bestScore = 0;
    for (let j = 0; j < headers.length; j++) {
      if (usedIdxs.has(j)) continue;
      const s = scoreCol(j);
      if (s > bestScore) { bestScore = s; best = j; }
    }
    return best;
  }

  /* ================= Init ================= */
  async function init() {
    try {
      const res = await fetch(CSV_URL, { cache: 'no-store' });
      const text = await res.text();
      const data = parseCSV(text);
      headers = data.shift() || [];
      console.log("Headers CSV:", headers);

      const I = {
        horo: colLike("Horodateur", "horodateur"),
        formation: colLike("Quelle formation avez vous suivie?", "formation"),
        pole: colLike("De quel Pôle faites vous partie ?", "pôle"),
        obj: colLike("Les objectif de la formation correspondaient ils à vos attentes ?", "attentes"),
        support: colLike("Etes vous satisfait de la qualité du support de formation proposé ?", "support"),
        aide: colLike("Etes vous satisfait de l'aide reçue lors de la manipulation ?", "aide"),
        rythme: colLike("Etes vous satisfait du rythme de la formation ?", "rythme"),
        formateur: colLike("Etes vous satisfait de la qualité des relations avec le formateur ?", "formateur"),
        reco: colLike("Recommanderiez vous cette formation ?", "recommander"),
        comments: colLike("Commentaires", "comment")
      };

      // fallback comments guess
      let needGuess = (I.comments === -1);
      if (!needGuess) {
        const hasAnyText = data.some(r => ((r[I.comments] ?? '').toString().trim().length > 0));
        if (!hasAnyText) needGuess = true;
      }
      if (needGuess) {
        const used = new Set(Object.values(I).filter(x => x !== -1 && x != null));
        const guessed = guessCommentsIndex(data, used);
        if (guessed !== -1) I.comments = guessed;
        else if (headers.length) I.comments = headers.length - 1;
      }

      rows = data.map(r => {
        const dt = parseFrDatetime(r[I.horo]);
        const vObj = parseLikert(r[I.obj]);
        const vSupport = parseLikert(r[I.support]);
        const vAide = parseLikert(r[I.aide]);
        const vRythme = parseLikert(r[I.rythme]);
        const vFormateur = parseLikert(r[I.formateur]);
        const vReco = parseLikert(r[I.reco]);
        const anyScore = [vObj, vSupport, vAide, vRythme, vFormateur, vReco].some(v => typeof v === 'number');
        if (!dt || !anyScore) return null;

        const formation = r[I.formation];
        const pole = r[I.pole];
        return {
          horo: r[I.horo],
          date: dt,
          formation, pole,
          formationNorm: norm(formation),
          poleNorm: norm(pole),
          obj: vObj,
          support: vSupport,
          aide: vAide,
          rythme: vRythme,
          formateur: vFormateur,
          reco: vReco,
          comments: r[I.comments]
        };
      }).filter(Boolean);

      setupFilters();
      applyFilters();

      document.getElementById('btn-export').onclick = () => window.print();

      (function () {
        let t;
        window.addEventListener('resize', () => { clearTimeout(t); t = setTimeout(() => renderAll(), 150); });
        window.addEventListener('orientationchange', () => { setTimeout(() => renderAll(), 150); });
      })();

    } catch (e) {
      console.error("Init error:", e);
    }
  }

  /* ================= Filters ================= */
  function setupFilters() {
    const fFormation = document.getElementById('f-formation');
    const fPole = document.getElementById('f-pole');
    const fFrom = document.getElementById('f-from');
    const fTo = document.getElementById('f-to');

    const mapForm = new Map();
    rows.forEach(r => { if (r.formationNorm && !mapForm.has(r.formationNorm)) mapForm.set(r.formationNorm, r.formation); });
    const mapPole = new Map();
    rows.forEach(r => { if (r.poleNorm && !mapPole.has(r.poleNorm)) mapPole.set(r.poleNorm, r.pole); });

    const optionsFromMap = (map) =>
      `<option value="">Tous</option>` +
      Array.from(map.entries()).map(([key, label]) => `<option value="${esc(key)}">${esc(label)}</option>`).join('');
    fFormation.innerHTML = optionsFromMap(mapForm);
    fPole.innerHTML = optionsFromMap(mapPole);

    fFrom.value = "";
    fTo.value = "";

    [fFormation, fPole, fFrom, fTo].forEach(el => el.addEventListener('change', applyFilters));
    document.getElementById('f-reset').addEventListener('click', () => {
      fFormation.value = ""; fPole.value = "";
      fFrom.value = ""; fTo.value = "";
      applyFilters();
    });
  }

  function applyFilters() {
    const fFormationKey = document.getElementById('f-formation').value || "";
    const fPoleKey = document.getElementById('f-pole').value || "";
    const fromStr = document.getElementById('f-from').value;
    const toStr = document.getElementById('f-to').value;
    const from = fromStr ? new Date(fromStr + "T00:00:00") : null;
    const to = toStr ? new Date(toStr + "T23:59:59") : null;

    filtered = rows.filter(r => {
      if (fFormationKey && r.formationNorm !== fFormationKey) return false;
      if (fPoleKey && r.poleNorm !== fPoleKey) return false;
      if (from && r.date && r.date < from) return false;
      if (to && r.date && r.date > to) return false;
      return true;
    });

    renderAll();
  }

  /* ================= Rendering ================= */
  function renderAll() {
    const N = filtered.length;

    const reco5 = filtered.filter(r => r.reco === 5).length;
    const recoPct = N ? Math.round(100 * reco5 / N) : 0;
    const objGood = filtered.filter(r => typeof r.obj === 'number' && r.obj >= 4).length;
    const objPct = N ? Math.round(100 * objGood / N) : 0;
    const CRITERIA = ['obj', 'support', 'aide', 'rythme', 'formateur', 'reco'];
    const globalMean = mean(CRITERIA.map(k => mean(filtered.map(r => r[k]))));

    document.getElementById('kpi-n').textContent = N;
    document.getElementById('kpi-reco').textContent = `${recoPct}%`;
    document.getElementById('kpi-obj-pct').textContent = `${objPct}%`;
    document.getElementById('kpi-mean').textContent = isFinite(globalMean) ? globalMean.toFixed(1) : '–';

    drawPieByCategory('chart-formation', groupCount(filtered, 'formation'), 'Répartition par formation');
    drawBarPole('chart-pole', groupCount(filtered, 'pole'), 'Répartition par pôle');
    drawMeans('chart-means', filtered, 'Moyennes par critère');
    drawCriterionPies(filtered);

    const listEl = document.getElementById('commentsSection');
    const items = filtered
      .filter(r => (r.comments || "").toString().trim().length)
      .map(r => {
        const meta = `${esc(r.horo || '')} • ${esc(r.formation || '–')} • ${esc(r.pole || '–')}`;
        const body = esc((r.comments || '')).replace(/\n/g, '<br>');
        return `<div class="uX-card_34" style="margin-bottom:8px;"><div class="uX-mutedText_s1" style="margin-bottom:6px;">${meta}</div><div>${body}</div></div>`;
      });
    listEl.innerHTML = items.length ? items.join("") : `<div class="uX-mutedText_s1">Aucun commentaire pour ce filtre.</div>`;
  }

  function groupCount(rows, key) { const m = new Map(); rows.forEach(r => { const k = r[key] || 'Non renseigné'; m.set(k, (m.get(k) || 0) + 1); }); return Array.from(m.entries()).sort((a, b) => b[1] - a[1]); }

  function drawPieByCategory(elId, pairs, title) {
    const isSmall = window.innerWidth < 700;
    const dt = new google.visualization.DataTable();
    dt.addColumn('string', 'Catégorie'); dt.addColumn('number', 'Nombre');
    dt.addRows(pairs);
    const opts = {
      title,
      backgroundColor: '#ffffff',
      chartArea: { left: 10, right: 10, top: 10, bottom: 10, width: '90%', height: '80%', backgroundColor: '#ffffff' },
      legend: { position: 'right', textStyle: { color: '#475569', fontSize: isSmall ? 10 : 12 } },
      titleTextStyle: { fontSize: 14, bold: true, color: '#0f172a' },
      pieHole: 0.35
    };
    new google.visualization.PieChart(document.getElementById(elId)).draw(dt, opts);
  }

  function drawBarPole(elId, pairs /*, title */) {
    const isSmall = window.innerWidth < 700;
    const rowsY = pairs.map(([lab, val]) => [toTitleCaseFr(lab || 'Non renseigné'), val]);
    const maxLabelLen = Math.max(...rowsY.map(r => r[0].length), 10);
    const pxPerChar = isSmall ? 6 : 7;
    const leftMargin = Math.min(260, Math.max(isSmall ? 90 : 120, Math.round(maxLabelLen * pxPerChar)));
    const dt = new google.visualization.DataTable();
    dt.addColumn('string', 'Catégorie'); dt.addColumn('number', 'Nombre');
    dt.addRows(rowsY);
    const axisFont = isSmall ? 9 : 10;
    new google.visualization.BarChart(document.getElementById(elId)).draw(dt, {
      backgroundColor: '#ffffff',
      chartArea: { left: leftMargin, right: 12, top: 8, bottom: isSmall ? 30 : 42, width: '100%', height: '72%', backgroundColor: '#ffffff' },
      legend: 'none',
      bar: { groupWidth: '80%' },
      hAxis: {
        title: 'Nombre',
        titleTextStyle: { color: '#475569', fontSize: axisFont, italic: false },
        viewWindowMode: 'explicit',
        viewWindow: { min: 0, max: 70 },
        ticks: [0, 10, 20, 30, 40, 50, 60, 70],
        textStyle: { color: '#475569', fontSize: axisFont },
        gridlines: { color: '#eef2f7' }
      },
      vAxis: {
        title: 'Pôles',
        titleTextStyle: { color: '#475569', fontSize: axisFont, italic: false },
        textStyle: { color: '#475569', fontSize: axisFont },
        gridlines: { color: '#eef2f7' }
      }
    });
  }

  function drawMeans(elId, rows, title) {
    const isSmall = window.innerWidth < 700;
    const labels = [
      ['obj', 'Objectifs de formation'],
      ['support', 'Qualité du support'],
      ['aide', 'Assistance manipulation'],
      ['rythme', 'Rythme'],
      ['formateur', 'Relation formateur'],
      ['reco', 'Recommandation formation']
    ];
    const avg = arr => { const x = arr.filter(v => typeof v === 'number' && !isNaN(v)); return x.length ? x.reduce((a, b) => a + b, 0) / x.length : 0; };

    const dt = new google.visualization.DataTable();
    dt.addColumn('string', 'Critère');
    dt.addColumn('number', 'Moyenne');
    dt.addColumn({ type: 'string', role: 'style' });
    dt.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

    labels.forEach(([k, lab]) => {
      const m = avg(rows.map(r => r[k]));
      dt.addRow([lab, m, `color: ${colorForMean(m)}`, `<div style="padding:6px 8px"><b>${lab}</b><br>Moyenne : <b>${isFinite(m) ? m.toFixed(2) : '–'}</b> / 5</div>`]);
    });

    const opts = {
      title,
      backgroundColor: '#ffffff',
      chartArea: { left: isSmall ? 48 : 80, right: 12, top: 24, bottom: isSmall ? 80 : 120, width: '85%', height: '68%', backgroundColor: '#ffffff' },
      legend: 'none',
      titleTextStyle: { fontSize: 14, bold: true, color: '#0f172a' },
      tooltip: { isHtml: true },
      vAxis: { viewWindow: { min: 0, max: 5 }, gridlines: { color: '#eef2f7' }, textStyle: { color: '#475569', fontSize: isSmall ? 10 : 12 } },
      hAxis: { slantedText: true, slantedTextAngle: isSmall ? 45 : 60, showTextEvery: 1, textStyle: { color: '#475569', fontSize: isSmall ? 10 : 11 } }
    };
    new google.visualization.ColumnChart(document.getElementById(elId)).draw(dt, opts);
  }

  /* ====== Camemberts 1→5 par critère ====== */
  function countsLikert(rows, key) {
    const c = [0, 0, 0, 0, 0];
    rows.forEach(r => {
      const v = r[key];
      if (typeof v === 'number' && v >= 1 && v <= 5) c[v - 1]++;
    });
    return [['1', c[0]], ['2', c[1]], ['3', c[2]], ['4', c[3]], ['5', c[4]]];
  }
  function drawCriterionPie(elId, title, pairs, colors) {
    const isSmall = window.innerWidth < 700;
    const dt = new google.visualization.DataTable();
    dt.addColumn('string', 'Note'); dt.addColumn('number', 'Nombre');
    dt.addRows(pairs);
    const opts = {
      title, backgroundColor: '#ffffff',
      chartArea: { left: 10, right: 10, top: 10, bottom: 10, width: '88%', height: '80%', backgroundColor: '#ffffff' },
      legend: { position: 'right', textStyle: { color: '#475569', fontSize: isSmall ? 10 : 12 } },
      titleTextStyle: { fontSize: 14, bold: true, color: '#0f172a' },
      pieHole: 0.35, colors: colors
    };
    new google.visualization.PieChart(document.getElementById(elId)).draw(dt, opts);
  }
  function drawCriterionPies(rows) {
    drawCriterionPie('pie-obj', 'Objectifs de formation — 1→5', countsLikert(rows, 'obj'), CRITERION_COLORS.obj);
    drawCriterionPie('pie-support', 'Qualité du support — 1→5', countsLikert(rows, 'support'), CRITERION_COLORS.support);
    drawCriterionPie('pie-aide', 'Assistance manipulation — 1→5', countsLikert(rows, 'aide'), CRITERION_COLORS.aide);
    drawCriterionPie('pie-rythme', 'Rythme — 1→5', countsLikert(rows, 'rythme'), CRITERION_COLORS.rythme);
    drawCriterionPie('pie-formateur', 'Relation formateur — 1→5', countsLikert(rows, 'formateur'), CRITERION_COLORS.formateur);
    drawCriterionPie('pie-reco', 'Recommandation — 1→5', countsLikert(rows, 'reco'), CRITERION_COLORS.reco);
  }

  /* ================= Crypto small cards (real-time mock with CoinGecko) ================= */
  const cryptoContainer = document.getElementById("uX-cryptoWrap") || document.getElementById("uX-cryptoWrap");
  const coins = ["bitcoin", "ethereum", "binancecoin", "solana","ripple", "cardano"];
  const apiUrl = `https://api.coingecko.com/api/v3/simple/price?ids=${coins.join(",")}&vs_currencies=usd&include_24hr_change=true`;

  async function fetchCryptoSmall() {
    try {
      const res = await fetch(apiUrl);
      const data = await res.json();
      renderCryptoCards(data);
    } catch (err) {
      console.error("Error fetching crypto:", err);
    }
  }

  function renderCryptoCards(data) {
    const container = cryptoContainer;
    container.innerHTML = "";
    for (const coin of coins) {
      const info = data[coin];
      if (!info) continue;
      const change = (info.usd_24h_change || 0);
      const changeStr = change.toFixed(2);
      const isPos = change >= 0;
      const card = document.createElement("div");
      card.className = "uX-cryptoCard_c1";
      card.innerHTML = `
        <div class="uX-cryptoHead_f2">
          <img class="uX-cryptoImg_3p" src="https://cryptologos.cc/logos/${coin}-logo.png" alt="${coin}">
          <div>
            <div class="uX-cryptoName_7a">${capitalize(coin)}</div>
          </div>
        </div>
        <div class="uX-cryptoPrice_q2">$${(info.usd || 0).toLocaleString()}</div>
        <div class="${isPos ? 'uX-cryptoPctPos_8g' : 'uX-cryptoPctNeg_8g'}">${isPos ? '▲' : '▼'} ${Math.abs(changeStr)}%</div>
        <canvas class="uX-sparkCanvas_11" data-color="${isPos ? '#00d084' : '#ff4b5c'}"></canvas>
      `;
      container.appendChild(card);
    }
    drawSparks();
  }

  function drawSparks() {
    document.querySelectorAll(".uX-sparkCanvas_11").forEach(canvas => {
      const ctx = canvas.getContext("2d");
      const color = canvas.dataset.color || "#00d084";
      // set pixel size for retina
      const DPR = window.devicePixelRatio || 1;
      const width = canvas.width = Math.floor(canvas.clientWidth * DPR);
      const height = canvas.height = Math.floor(canvas.clientHeight * DPR);
      ctx.clearRect(0,0,width,height);
      ctx.strokeStyle = color;
      ctx.lineWidth = 2 * DPR;
      ctx.beginPath();
      const points = 10;
      let x = 0;
      ctx.moveTo(0, height/2);
      for (let i = 0; i < points; i++) {
        const y = height/2 + (Math.random()-0.5) * (height * 0.5);
        ctx.lineTo(x, y);
        x += width/points;
      }
      ctx.stroke();
    });
  }

  function capitalize(str){ return str.charAt(0).toUpperCase() + str.slice(1); }

  // initial + interval
  fetchCryptoSmall();
  setInterval(fetchCryptoSmall, 10000);

  /* =============== Top coins table (markets) =============== */
  const tableBody = document.getElementById("vx91x-body");
  async function fetchCryptoTable() {
    try {
      const url = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=5&page=1&sparkline=true";
      const res = await fetch(url);
      const data = await res.json();
      renderTable(data);
    } catch (err) {
      console.error("Error fetching crypto table:", err);
    }
  }

  function renderTable(data) {
    tableBody.innerHTML = "";
    data.forEach((coin, index) => {
      const price = coin.current_price.toLocaleString();
      const marketCap = formatMarketCap(coin.market_cap);
      const change = (coin.price_change_percentage_24h || 0).toFixed(2);
      const colorClass = change >= 0 ? 'uX-positive_p1' : 'uX-negative_n1';
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${index+1}</td>
        <td class="uX-nameCell_t1">
          <img src="${coin.image}" alt="${coin.name}" style="width:22px;height:22px;">
          <div><strong>${coin.name}</strong><br><small>${coin.symbol.toUpperCase()}</small></div>
        </td>
        <td>$${marketCap}</td>
        <td>$${price}</td>
        <td class="${colorClass}">${change >= 0 ? '▲' : '▼'} ${Math.abs(change)}%</td>
        <td><canvas class="uX-miniSpark_2n" data-points='${JSON.stringify(coin.sparkline_in_7d.price)}' data-color="${change >= 0 ? '#00c853' : '#e53935'}'></canvas></td>
        <td style="display:flex;align-items:center;gap:8px;"><img src="https://flagcdn.com/us.svg" style="width:18px;"> USA</td>
      `;
      tableBody.appendChild(row);
    });
    drawMiniCharts();
  }

  function drawMiniCharts() {
    document.querySelectorAll(".uX-miniSpark_2n").forEach((canvas) => {
      const ctx = canvas.getContext("2d");
      const DPR = window.devicePixelRatio || 1;
      const w = canvas.width = Math.floor(canvas.clientWidth * DPR);
      const h = canvas.height = Math.floor(canvas.clientHeight * DPR);
      const color = canvas.dataset.color || "#00c853";
      const points = JSON.parse(canvas.dataset.points || "[]");
      if (!points.length) return;
      const min = Math.min(...points);
      const max = Math.max(...points);
      ctx.clearRect(0,0,w,h);
      ctx.strokeStyle = color;
      ctx.lineWidth = 2 * DPR;
      ctx.beginPath();
      points.forEach((p, i) => {
        const x = (i / (points.length - 1)) * w;
        const y = h - ((p - min) / (max - min || 1)) * h;
        if (i === 0) ctx.moveTo(x,y);
        else ctx.lineTo(x,y);
      });
      ctx.stroke();
    });
  }

  function formatMarketCap(cap) {
    if (cap >= 1e12) return (cap / 1e12).toFixed(2) + " T";
    if (cap >= 1e9) return (cap / 1e9).toFixed(2) + " B";
    if (cap >= 1e6) return (cap / 1e6).toFixed(2) + " M";
    return (cap || 0).toFixed(2);
  }

  fetchCryptoTable();
  setInterval(fetchCryptoTable, 10000);

  /* ================= Company detailed (NVDA) using Chart.js ================= */
  const logo = document.getElementById("xx-logo");
  const nameEl = document.getElementById("xx-name");
  const symbolEl = document.getElementById("xx-symbol");
  const marketCapEl = document.getElementById("xx-marketcap");
  const priceEl = document.getElementById("xx-price");
  const changeEl = document.getElementById("xx-change");
  const chartCanvas = document.getElementById("xx-chart");
  let chartInstance = null;

  async function getDataCompany() {
    try {
      const res = await fetch("https://api.coingecko.com/api/v3/coins/nvidia");
      const data = await res.json();
      const { image, name, symbol, market_data } = data;
      const marketCap = market_data.market_cap.usd;
      const price = market_data.current_price.usd;
      const change = market_data.price_change_percentage_24h;
      const prices = await getMarketChart();

      logo.src = image.small;
      nameEl.textContent = name;
      symbolEl.textContent = symbol.toUpperCase();
      marketCapEl.textContent = `$${formatNumber(marketCap)}`;
      priceEl.textContent = `$${price.toFixed(2)}`;
      changeEl.textContent = `${change.toFixed(2)}%`;
      changeEl.className = change >= 0 ? 'uX-positive_p1' : 'uX-negative_n1';

      renderCompanyChart(prices);
    } catch (err) {
      console.error("Error company data:", err);
    }
  }

  async function getMarketChart() {
    try {
      const res = await fetch("https://api.coingecko.com/api/v3/coins/nvidia/market_chart?vs_currency=usd&days=90");
      const data = await res.json();
      return data.prices.map(p => p[1]);
    } catch (e) {
      console.error("chart fetch error", e);
      return [];
    }
  }

  function renderCompanyChart(points) {
    if (!chartCanvas) return;
    const ctx = chartCanvas.getContext("2d");
    if (chartInstance) chartInstance.destroy();
    chartInstance = new Chart(ctx, {
      type: 'line',
      data: {
        labels: points.map((_, i) => i),
        datasets: [{ data: points, borderColor: '#f5a623', fill: false, tension: 0.3, borderWidth: 2 }]
      },
      options: {
        scales: { x: { display: false }, y: { display: false } },
        plugins: { legend: { display: false } },
        maintainAspectRatio: false
      }
    });
  }

  function formatNumber(num) {
    if (!num) return "0.00";
    if (num >= 1e12) return (num / 1e12).toFixed(2) + " T";
    if (num >= 1e9) return (num / 1e9).toFixed(2) + " B";
    if (num >= 1e6) return (num / 1e6).toFixed(2) + " M";
    return num.toFixed(2);
  }

  getDataCompany();
  setInterval(getDataCompany, 10000);

  // finally kick-off google charts init already called earlier
  
  
        // Schema toggle via URL
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const getSchema = urlParams.get("schema");
        if (getSchema === "dark") {
            setDarkMode(1);
        } else if (getSchema === "light") {
            setDarkMode(0);
        }
    