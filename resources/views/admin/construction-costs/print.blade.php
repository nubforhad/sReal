<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, viewport-fit=cover"
    />
    <title>Safe Community – Money Receipt</title>
    <style>
      :root {
        --bg: #d8d3ca;
        --paper: #f0e5d5;
        --bar: #a98a55;
        --ink: #1c1c1c;
        --dot: #444;
        box-sizing: border-box;
        padding-top: env(safe-area-inset-top, 0px);
        padding-bottom: env(safe-area-inset-bottom, 0px);
      }
      @media (prefers-color-scheme: dark) {
        :root:not([data-theme="light"]) {
          --bg: #26241f;
        }
      }
      :root[data-theme="dark"] {
        --bg: #26241f;
      }
      html,
      body {
        margin: 0;
        height: 100%;
      }
      body {
        background: var(--bg);
        font-family: Arial, Helvetica, sans-serif;
        color: var(--ink);
        overflow-x: hidden;
      }
      #stage {
        width: 1600px;
        height: 570px;
        transform-origin: 0 0;
        position: absolute;
        left: 0;
        top: 50%;
      }
      .sheet {
        position: relative;
        width: 1600px;
        height: 570px;
        background: var(--paper);
        display: flex;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.35);
        background-image:
          radial-gradient(
            circle at 60% 55%,
            rgba(150, 120, 80, 0.07) 0 160px,
            transparent 161px
          ),
          radial-gradient(
            circle at 20% 50%,
            rgba(150, 120, 80, 0.06) 0 120px,
            transparent 121px
          );
      }
      .sheet::before,
      .sheet::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        height: 22px;
        background: var(--bar);
        z-index: 1;
      }
      .sheet::before {
        top: 0;
      }
      .sheet::after {
        bottom: 0;
      }
      .part {
        position: relative;
        box-sizing: border-box;
        padding: 40px 30px 40px 36px;
      }
      .stub {
        width: 660px;
        border-right: 1px dashed #8a7a62;
      }
      .main {
        flex: 1;
        padding-left: 34px;
        padding-right: 34px;
      }
      .hdr {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
      }
      .brand {
        display: flex;
        flex-direction: column;
      }
      .logo-row {
        display: flex;
        align-items: center;
        gap: 6px;
      }
      .safe {
        font:
          900 42px/1 "Arial Black",
          Arial,
          sans-serif;
        letter-spacing: -3px;
        position: relative;
        padding-top: 8px;
      }
      .safe small {
        position: absolute;
        left: 0;
        top: 0;
        font: 700 6px Arial;
        letter-spacing: 0;
      }
      .emb {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: 5px solid #222;
        box-sizing: border-box;
        margin-left: -4px;
        background: radial-gradient(circle, #222 0 4px, transparent 5px);
      }
      .co {
        font:
          900 24px/1 "Arial Black",
          Arial,
          sans-serif;
        margin-left: 6px;
      }
      .addr {
        font-size: 10.5px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
      }
      .addr i {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        background: #222;
        display: inline-block;
      }
      .gard {
        display: flex;
        align-items: flex-start;
        gap: 4px;
      }
      .gard .big {
        width: 50px;
        height: 30px;
        border: 1.5px solid #222;
      }
      .gard b {
        border: 1.5px solid #222;
        font: 800 12px Arial;
        padding: 5px 6px;
        white-space: nowrap;
      }
      .row1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
      }
      .no {
        font-size: 12px;
      }
      .no span {
        font:
          400 26px "Segoe Print",
          "Comic Sans MS",
          cursive;
        margin-left: 6px;
        letter-spacing: 1px;
      }
      .mr {
        font: italic 800 17px Arial;
        margin-left: 20px;
      }
      .date {
        display: flex;
        align-items: center;
        font-size: 11px;
        gap: 4px;
      }
      .dbox {
        display: flex;
        border: 1px solid #8a7a62;
        background: #f6efe3;
        height: 22px;
      }
      .dbox span {
        width: 22px;
        border-right: 1px solid #8a7a62;
      }
      .dbox span:last-child {
        border: 0;
        width: 30px;
      }
      .f {
        display: flex;
        align-items: flex-end;
        font-size: 11px;
        margin-top: 20px;
        height: 16px;
      }
      .f label {
        white-space: nowrap;
      }
      .f .l {
        flex: 1;
        border-bottom: 1.5px dotted var(--dot);
        height: 12px;
        margin-left: 3px;
      }
      .f .l.s {
        flex: 0 0 auto;
        width: 160px;
      }
      .main .f .l.s {
        width: 290px;
      }
      .f .br {
        margin-left: 6px;
      }
      .stub .thru-date {
        display: none;
      }
      .tk {
        margin-top: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .tkb {
        width: 190px;
        height: 38px;
        border: 1.5px solid #222;
        background: #f6efe3;
        font: 800 18px Arial;
        padding: 5px 6px;
        box-sizing: border-box;
      }
      .sig {
        position: absolute;
        left: 36px;
        right: 30px;
        bottom: 30px;
        display: flex;
        justify-content: space-between;
        font: 600 12px Arial;
      }
      .main .sig {
        left: 34px;
        right: 34px;
      }
      .sig span {
        border-top: 0;
      }
      .stamp {
        position: absolute;
        left: 530px;
        top: 140px;
        width: 210px;
        height: 170px;
        transform: rotate(-8deg);
        z-index: 3;
        mix-blend-mode: multiply;
        pointer-events: none;
      }
    </style>
  </head>
  <body>
    <div id="stage"><div class="sheet" id="sheet"></div></div>

    <template id="tpl">
      <div class="part {{cls}}">
        <div class="hdr">
          <div class="brand">
            <div class="logo-row">
              <div class="safe"><small>COMMUNITY</small>SAFE</div>
              <div class="emb"></div>
              <div class="co">SAFE COMMUNITY REAL ESTATE LTD.</div>
            </div>
            <div class="addr">
              <i></i>Anowar Plaza (2<sup>nd</sup> Floor), Mintu Chattar,
              Matuail, Demra, Dhaka <i></i> 01713 167754, 01713 878824
            </div>
          </div>
          <div class="gard">
            <div class="big"></div>
            <b>SAFE GARDEN</b>
          </div>
        </div>
        <div class="row1">
          <div class="no">No. <span>7008</span></div>
          <div class="mr">Money Receipt</div>
          <div class="date">
            Date :
            <div class="dbox"><span></span><span></span><span></span></div>
          </div>
        </div>
        <div class="f">
          <label>Mr./Mrs./Miss. :</label>
          <div class="l"></div>
        </div>
        <div class="f">
          <label>Address :</label>
          <div class="l"></div>
        </div>
        <div class="f">
          <label>Customer ID No. :</label>
          <div class="l"></div>
        </div>
        <div class="f">
          <label>Purpose (Booking/Down Payment/Inst/Others) :</label>
          <div class="l"></div>
        </div>
        <div class="f">
          <label>Through Cash/RTGS/NPSB/EFTN/PO/Online/Cheque No. :</label>
          <div class="l"></div>
          <label class="br thru-date">Date :</label>
          <div class="l s thru-date"></div>
        </div>
        <div class="f">
          <label>Bank :</label>
          <div class="l"></div>
          <label class="br">Branch :</label>
          <div class="l s"></div>
        </div>
        <div class="f">
          <label>In words :</label>
          <div class="l"></div>
        </div>
        <div class="tk"><div class="tkb">Tk.</div></div>
        <div class="sig">
          <span>Received By</span><span>Authorized by</span>
        </div>
      </div>
    </template>

    <template id="stamp">
      <svg class="stamp" viewBox="0 0 210 170" fill="none"
        stroke="#3b2fa8"
        xmlns="http://www.w3.org/2000/svg"
      >
        <ellipse cx="105" cy="85" rx="100" ry="78" stroke-width="3" />
        <ellipse cx="105" cy="85" rx="64" ry="46" stroke-width="1.5" />
        <defs>
          <path id="top" d="M20 85a85 63 0 0 1 170 0" />
          <path id="bot" d="M14 92a91 70 0 0 0 182 0" />
        </defs>
        <text font-family="Arial" font-weight="800" font-size="15" fill="#3b2fa8" stroke="none" letter-spacing="3">
          <textPath href="#top" startOffset="50%" text-anchor="middle">
            SAFE
          </textPath>
        </text>
        <text font-family="Arial" font-weight="800" font-size="14" fill="#3b2fa8" stroke="none" letter-spacing="2"  >
          <textPath href="#bot" startOffset="50%" text-anchor="middle">
            COMMUNITY GROUP
          </textPath>
        </text>
        <text
          x="105"
          y="95"
          text-anchor="middle"
          font-family="Arial Black,Arial"
          font-weight="900"
          font-size="34"
          fill="#3b2fa8"
          stroke="none"
        >
          SAFE
        </text>
        <text
          x="105"
          y="62"
          text-anchor="middle"
          font-size="9"
          font-family="Arial"
          fill="#3b2fa8"
          stroke="none"
        >
          ★ ★
        </text>
      </svg>
    </template>

    <script>
      (function () {
        var t = document.getElementById("tpl").innerHTML,
          s = document.getElementById("sheet");
        s.innerHTML =
          t.replace("{{cls}}", "stub") +
          t.replace("{{cls}}", "main") +
          document.getElementById("stamp").innerHTML;
        var st = document.getElementById("stage");
        function fit() {
          var k = Math.min(window.innerWidth / 1600, 1.6);
          st.style.transform = "scale(" + k + ")";
          st.style.marginTop = (-570 * k) / 2 + "px";
        }
        window.addEventListener("resize", fit);
        fit();
      })();
    </script>
  </body>
</html>
