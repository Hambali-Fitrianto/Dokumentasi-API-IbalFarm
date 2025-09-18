<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>IbalFarm API — Dokumentasi</title>
  <meta name="description" content="Dokumentasi resmi IbalFarm API: autentikasi token, endpoints farms/cages/animals, catatan berat & vaksin, contoh cURL, dan panduan penggunaan.">
  <style>
    :root{
      --bg:#0b0e14; --paper:#0f131a; --ink:#e6edf3; --muted:#a0a7b4; --border:#1f2630;
      --brand:#5b9cff; --accent:#22c55e; --danger:#ef4444; --code-bg:#0b0e14; --kbd:#111827;
    }
    html.light {
      --bg:#f8fafc; --paper:#ffffff; --ink:#0b1220; --muted:#5b6472; --border:#e5e7eb;
      --brand:#2563eb; --accent:#16a34a; --danger:#dc2626; --code-bg:#0f172a; --kbd:#f3f4f6;
    }
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.65 ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Inter,"Helvetica Neue",Arial}
    a{color:var(--brand);text-decoration:none}
    code,kbd,pre{font-family: ui-monospace,SFMono-Regular,Menlo,Consolas,Monaco,"Liberation Mono","Courier New",monospace}
    .container{max-width:1100px;margin:0 auto;padding:28px 16px}
    header.hero{display:flex;flex-wrap:wrap;gap:16px;align-items:center;justify-content:space-between;margin-bottom:18px}
    .title h1{font-size:28px;margin:0 0 6px}
    .title p{margin:0;color:var(--muted)}
    .actions{display:flex;gap:10px}
    .btn{padding:8px 12px;border-radius:10px;border:1px solid var(--border);background:var(--paper);color:var(--ink);cursor:pointer}
    .btn.primary{background:var(--brand);border-color:transparent;color:#fff}
    .btn.ghost{background:transparent}
    .card{background:var(--paper);border:1px solid var(--border);border-radius:14px;padding:18px}
    .grid{display:grid;grid-template-columns:260px 1fr;gap:16px}
    @media (max-width: 980px){.grid{grid-template-columns:1fr}}
    nav.toc{position:sticky;top:16px;height:fit-content}
    nav.toc .block{margin-bottom:14px}
    nav.toc h3{margin:0 0 8px;font-size:14px;color:var(--muted)}
    nav.toc a{display:block;padding:6px 10px;border-radius:8px;color:var(--ink)}
    nav.toc a:hover{background:var(--border)}
    h2{margin:22px 0 10px}
    h3{margin:18px 0 8px}
    .kbd{background:var(--kbd);padding:2px 6px;border-radius:6px;border:1px solid var(--border)}
    pre{background:var(--code-bg);color:#e5e7eb;border-radius:12px;padding:14px;border:1px solid var(--border);overflow:auto;position:relative}
    pre .copy{position:absolute;top:8px;right:8px;border:1px solid var(--border);background:rgba(255,255,255,0.06);color:#fff;padding:6px 8px;border-radius:8px;cursor:pointer;font-size:12px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid var(--border);vertical-align:top}
    th{color:var(--muted);text-align:left}
    .pill{display:inline-block;padding:2px 8px;border-radius:999px;border:1px solid var(--border);font-size:12px}
    .muted{color:var(--muted)}
    .callout{border-left:4px solid var(--brand);padding:10px 12px;background:color-mix(in oklab, var(--brand) 8%, var(--paper));border-radius:8px;margin:10px 0}
    .warn{border-left-color:var(--danger);background:color-mix(in oklab, var(--danger) 8%, var(--paper))}
    .ok{border-left-color:var(--accent);background:color-mix(in oklab, var(--accent) 8%, var(--paper))}
    footer{margin-top:28px;color:var(--muted);text-align:center}
    .kbd-row{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
  </style>
</head>
<body class="light">
  <div class="container">
    <header class="hero">
      <div class="title">
        <h1>IbalFarm API — Dokumentasi</h1>
        <p>API manajemen peternakan (farms, cages, animals, bobot & vaksin). Auth dengan Bearer Token.</p>
      </div>
      <div class="actions">
        <button id="toggleTheme" class="btn">🌗 Mode</button>
        <a class="btn ghost" href="#quickstart">⚡ Quickstart</a>
        <a class="btn primary" href="#endpoints">📚 Endpoints</a>
      </div>
    </header>

    <div class="grid">
      <nav class="toc card">
        <div class="block">
          <h3>Umum</h3>
          <a href="#overview">Overview</a>
          <a href="#base-url">Base URL</a>
          <a href="#auth">Autentikasi</a>
          <a href="#status-error">Status & Error</a>
        </div>
        <div class="block">
          <h3>Endpoints</h3>
          <a href="#farms">Farms</a>
          <a href="#cages">Cages</a>
          <a href="#animals">Animals</a>
          <a href="#weights">Animal Weights</a>
          <a href="#vaccines">Animal Vaccines</a>
        </div>
        <div class="block">
          <h3>Contoh</h3>
          <a href="#curl">cURL</a>
          <a href="#postman">Postman</a>
          <a href="#schema">Skema Data</a>
        </div>
        <div class="block">
          <h3>Lainnya</h3>
          <a href="#security">Keamanan</a>
          <a href="#contact">Kontak</a>
        </div>
      </nav>

      <main class="card" id="content">

        <section id="overview">
          <h2>Overview</h2>
          <p><strong>IbalFarm API</strong> menyediakan layanan REST untuk mengelola peternakan: <em>Farm</em>, <em>Cage</em>, <em>Animal</em>, serta catatan <em>Berat</em> dan <em>Vaksin</em>. Semua response dalam format <code>JSON</code>.</p>
          <div class="callout ok">
            <strong>Auth:</strong> Bearer Token (custom). Dapatkan token via <a href="#login">Login</a>, lalu kirim di header <code>Authorization: Bearer &lt;TOKEN&gt;</code>.
          </div>
        </section>

        <section id="base-url">
          <h2>Base URL</h2>
          <table>
            <tr><th>Lingkungan</th><th>URL</th></tr>
            <tr><td>Local</td><td><code>{{BASE_URL}}</code> (contoh: <code>http://localhost:8000/api</code>)</td></tr>
            <tr><td>Production</td><td>ganti sesuai domain API kamu, mis: <code>https://api.ibalfarm.com/api</code></td></tr>
          </table>
          <p class="muted">Seluruh contoh di halaman ini memakai placeholder <code>{{BASE_URL}}</code>. Ganti dengan URL kamu.</p>
        </section>

        <section id="quickstart">
          <h2>Quickstart</h2>
          <ol>
            <li><strong>Login</strong> untuk mendapatkan token.</li>
            <li>Gunakan token pada semua request protected: <code>Authorization: Bearer &lt;TOKEN&gt;</code>.</li>
            <li>Coba endpoint <a href="#farms">Farms</a> untuk membuat farm pertama kamu.</li>
          </ol>
          <pre><button class="copy">Copy</button><code>curl -X POST {{BASE_URL}}/auth/login \
  -H "Content-Type: application/json" -H "Accept: application/json" \
  -d '{"login":"admin@ibalfarm.local","password":"admin123"}'</code></pre>
        </section>

        <section id="auth">
          <h2>Autentikasi</h2>

          <h3 id="login">Login</h3>
          <p>Mendapatkan token untuk dipakai pada request berikutnya.</p>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/auth/login</code></td></tr>
            <tr><th>Headers</th><td><code>Content-Type: application/json</code>, <code>Accept: application/json</code></td></tr>
          </table>
<pre><button class="copy">Copy</button><code>{
  "login": "email atau username",
  "password": "password"
}</code></pre>
<pre><code>{
  "token": "44da5ae8...<64-hex>..."
}</code></pre>

          <h3>Register (opsional/dev)</h3>
          <p>Buat user baru dan langsung dapat token. <span class="muted">(Sebaiknya dimatikan di production)</span></p>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/auth/register</code></td></tr>
          </table>
<pre><button class="copy">Copy</button><code>{
  "name": "Admin",
  "username": "admin",
  "email": "admin@contoh.local",
  "password": "admin123"
}</code></pre>

          <h3>Profil (cek token)</h3>
          <table>
            <tr><th>Method</th><td><span class="pill">GET</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/auth/me</code></td></tr>
            <tr><th>Headers</th><td><code>Authorization: Bearer &lt;TOKEN&gt;</code></td></tr>
          </table>

          <h3>Logout</h3>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/auth/logout</code></td></tr>
            <tr><th>Headers</th><td><code>Authorization: Bearer &lt;TOKEN&gt;</code></td></tr>
          </table>
        </section>

        <section id="endpoints">
          <h2>Endpoints</h2>

          <h3 id="farms">Farms</h3>
          <p>Kelola data peternakan milik user login.</p>

          <h4>List Farms</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">GET</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/farms?search=&lt;string&gt;</code></td></tr>
            <tr><th>Headers</th><td><code>Authorization: Bearer &lt;TOKEN&gt;</code></td></tr>
          </table>
<pre><code>{
  "data": [
    { "id": 1, "name": "Bojay Farm", "location": "Bangkalan", "notes": "Sapi & kambing", "owner_id": 1, "cages_count": 3, "created_at": "...", "updated_at": "..." }
  ],
  "links": { "...": "..." },
  "meta": { "current_page": 1, "per_page": 10, "total": 1 }
}</code></pre>

          <h4>Create Farm</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/farms</code></td></tr>
          </table>
<pre><button class="copy">Copy</button><code>{
  "name": "Bojay Farm",
  "location": "Bangkalan",
  "notes": "Catatan opsional"
}</code></pre>

          <h4>Show / Update / Delete</h4>
          <table>
            <tr><th>Show</th><td><code>GET {{BASE_URL}}/farms/{id}</code></td></tr>
            <tr><th>Update</th><td><code>PUT {{BASE_URL}}/farms/{id}</code></td></tr>
            <tr><th>Delete</th><td><code>DELETE {{BASE_URL}}/farms/{id}</code></td></tr>
          </table>

          <hr style="border-color:var(--border)">

          <h3 id="cages">Cages</h3>
          <p>Kandang di dalam sebuah farm.</p>

          <h4>List Cages</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">GET</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/cages?farm_id=&lt;id&gt;</code></td></tr>
          </table>

          <h4>Create Cage</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/cages</code></td></tr>
          </table>
<pre><button class="copy">Copy</button><code>{
  "farm_id": 1,
  "code": "KDG-01",
  "type": "sapi",
  "capacity": 20,
  "notes": ""
}</code></pre>

          <h4>Show / Update / Delete</h4>
          <table>
            <tr><th>Show</th><td><code>GET {{BASE_URL}}/cages/{id}</code></td></tr>
            <tr><th>Update</th><td><code>PUT {{BASE_URL}}/cages/{id}</code></td></tr>
            <tr><th>Delete</th><td><code>DELETE {{BASE_URL}}/cages/{id}</code></td></tr>
          </table>

          <hr style="border-color:var(--border)">

          <h3 id="animals">Animals</h3>
          <p>Hewan ternak per kandang (cage).</p>

          <h4>List Animals</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">GET</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/animals?cage_id=&lt;id&gt;&amp;species=&lt;text&gt;&amp;status=&lt;active|sold|dead&gt;&amp;search=&lt;tag&gt;</code></td></tr>
          </table>

          <h4>Create Animal</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/animals</code></td></tr>
          </table>
<pre><button class="copy">Copy</button><code>{
  "cage_id": 10,
  "tag": "SAPI-001",
  "species": "sapi",
  "breed": "",
  "sex": "M",
  "status": "active",
  "notes": ""
}</code></pre>

          <h4>Show / Update / Delete</h4>
          <table>
            <tr><th>Show</th><td><code>GET {{BASE_URL}}/animals/{id}</code></td></tr>
            <tr><th>Update</th><td><code>PUT {{BASE_URL}}/animals/{id}</code></td></tr>
            <tr><th>Delete</th><td><code>DELETE {{BASE_URL}}/animals/{id}</code></td></tr>
          </table>

          <hr style="border-color:var(--border)">

          <h3 id="weights">Animal Weights</h3>

          <h4>List</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">GET</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/animals/{animal_id}/weights</code></td></tr>
          </table>

          <h4>Create</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/animals/{animal_id}/weights</code></td></tr>
          </table>
<pre><button class="copy">Copy</button><code>{
  "weighed_at": "2025-09-19",
  "weight_kg": 220.5,
  "method": "",
  "notes": ""
}</code></pre>

          <hr style="border-color:var(--border)">

          <h3 id="vaccines">Animal Vaccines</h3>

          <h4>List</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">GET</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/animals/{animal_id}/vaccines</code></td></tr>
          </table>

          <h4>Create</h4>
          <table>
            <tr><th>Method</th><td><span class="pill">POST</span></td></tr>
            <tr><th>URL</th><td><code>{{BASE_URL}}/animals/{animal_id}/vaccines</code></td></tr>
          </table>
<pre><button class="copy">Copy</button><code>{
  "vaccinated_at": "2025-09-19",
  "vaccine_name": "Anthrax",
  "dose": "",
  "notes": ""
}</code></pre>

        </section>

        <section id="status-error">
          <h2>Status Kode & Error</h2>
          <table>
            <tr><th>200</th><td>OK – Permintaan sukses</td></tr>
            <tr><th>201</th><td>Created – Data berhasil dibuat</td></tr>
            <tr><th>204</th><td>No Content – Tanpa body (mis: delete)</td></tr>
            <tr><th>400</th><td>Bad Request – Format salah</td></tr>
            <tr><th>401</th><td>Unauthorized – Token tidak ada/invalid</td></tr>
            <tr><th>403</th><td>Forbidden – Resource bukan milik user</td></tr>
            <tr><th>404</th><td>Not Found – Resource tidak ditemukan</td></tr>
            <tr><th>422</th><td>Unprocessable Entity – Validasi gagal</td></tr>
            <tr><th>429</th><td>Too Many Requests – Rate limit</td></tr>
            <tr><th>500</th><td>Internal Server Error – Cek log server</td></tr>
          </table>
<pre><code>{
  "message": "The given data was invalid.",
  "errors": { "tag": ["The tag has already been taken."] }
}</code></pre>
        </section>

        <section id="curl">
          <h2>Contoh cURL</h2>
          <h3>Login</h3>
<pre><button class="copy">Copy</button><code>curl -X POST {{BASE_URL}}/auth/login \
  -H "Content-Type: application/json" -H "Accept: application/json" \
  -d '{"login":"admin@ibalfarm.local","password":"admin123"}'</code></pre>

          <h3>List Farms</h3>
<pre><button class="copy">Copy</button><code>curl {{BASE_URL}}/farms \
  -H "Accept: application/json" \
  -H "Authorization: Bearer &lt;TOKEN&gt;"</code></pre>

          <h3>Create Animal</h3>
<pre><button class="copy">Copy</button><code>curl -X POST {{BASE_URL}}/animals \
  -H "Content-Type: application/json" -H "Accept: application/json" \
  -H "Authorization: Bearer &lt;TOKEN&gt;" \
  -d '{"cage_id":10,"tag":"SAPI-001","species":"sapi","sex":"M","status":"active"}'</code></pre>
        </section>

        <section id="postman">
          <h2>Postman</h2>
          <ol>
            <li>Buat request <kbd class="kbd">POST</kbd> <code>{{BASE_URL}}/auth/login</code> → ambil token.</li>
            <li>Set <em>Collection / Environment variable</em> bernama <code>token</code>.</li>
            <li>Di setiap request protected, tambah header: <code>Authorization: Bearer {{token}}</code></li>
          </ol>
          <div class="callout warn">
            Jika muncul <strong>422</strong>, periksa bahwa Body kamu <em>raw JSON</em> dan header <code>Content-Type: application/json</code> aktif.
          </div>
        </section>

        <section id="schema">
          <h2>Skema Data (ringkas)</h2>
          <h3>Farm</h3>
<pre><code>{ "id": 1, "name": "string", "location": "string|null", "notes": "string|null", "owner_id": 1, "created_at": "...", "updated_at": "..." }</code></pre>
          <h3>Cage</h3>
<pre><code>{ "id": 10, "farm_id": 1, "code": "string", "type": "string|null", "capacity": 0, "notes": "string|null" }</code></pre>
          <h3>Animal</h3>
<pre><code>{ "id": 99, "cage_id": 10, "tag": "string", "species": "string", "breed": "string|null", "sex": "M|F|null", "birth_date": "date|null", "entry_date": "date|null", "status": "active|sold|dead", "notes": "string|null" }</code></pre>
          <h3>AnimalWeight</h3>
<pre><code>{ "id": 1, "animal_id": 99, "weighed_at": "date", "weight_kg": "decimal", "method": "string|null", "notes": "string|null" }</code></pre>
          <h3>AnimalVaccine</h3>
<pre><code>{ "id": 1, "animal_id": 99, "vaccinated_at": "date", "vaccine_name": "string", "dose": "string|null", "notes": "string|null" }</code></pre>
        </section>

        <section id="security">
          <h2>Keamanan & Praktik Baik</h2>
          <ul>
            <li>Simpan token di klien secara aman (jangan commit ke repo publik).</li>
            <li>Batasi CORS hanya ke domain frontend produksi.</li>
            <li>Matikan endpoint <em>register</em> publik jika tidak dibutuhkan.</li>
            <li>Aktifkan HTTPS di production, dan lakukan backup database rutin.</li>
          </ul>
        </section>

        <section id="contact">
          <h2>Kontak / Lisensi</h2>
          <p><strong>Developer & Maintainer:</strong> Hambali Fitrianto</p>
          <p><strong>Email:</strong> <em>hambali.fitrianto01@gmail.com</em></p>
          <p><strong>Lisensi:</strong> <em>MIT / Proprietary</em></p>
        </section>

        <footer>
          <p>IbalFarm API Docs • dibuat dengan ❤ • Mode <span id="modeLabel">Terang</span></p>
        </footer>
      </main>
    </div>
  </div>

  <script>
    // Theme toggle
    const toggleBtn = document.getElementById('toggleTheme');
    const modeLabel = document.getElementById('modeLabel');
    function setTheme(mode){
      if(mode === 'dark'){ document.body.classList.remove('light'); localStorage.setItem('theme','dark'); modeLabel.textContent='Gelap'; }
      else { document.body.classList.add('light'); localStorage.setItem('theme','light'); modeLabel.textContent='Terang'; }
    }
    const saved = localStorage.getItem('theme') || 'light';
    setTheme(saved);
    toggleBtn.addEventListener('click', ()=> setTheme(document.body.classList.contains('light') ? 'dark' : 'light'));

    // Copy buttons
    document.querySelectorAll('pre .copy').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const code = btn.nextElementSibling?.innerText || '';
        navigator.clipboard.writeText(code).then(()=>{
          const old = btn.textContent;
          btn.textContent = 'Copied!';
          setTimeout(()=> btn.textContent = old, 1200);
        });
      });
    });
  </script>
</body>
</html>
