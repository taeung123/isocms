<script type="text/template" id="alert-layout-modern">
    <div class="iso-modern">

        <div class="icon-wrap">
            <svg class="sparkle s1" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0 L14 10 L24 12 L14 14 L12 24 L10 14 L0 12 L10 10 Z"/></svg>
            <svg class="sparkle s2" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0 L14 10 L24 12 L14 14 L12 24 L10 14 L0 12 L10 10 Z"/></svg>
            <svg class="sparkle s3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0 L14 10 L24 12 L14 14 L12 24 L10 14 L0 12 L10 10 Z"/></svg>
            <svg class="sparkle s4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0 L14 10 L24 12 L14 14 L12 24 L10 14 L0 12 L10 10 Z"/></svg>

            <svg class="shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2 L20 5.5 V11 C20 16 16.5 19.8 12 22 C7.5 19.8 4 16 4 11 V5.5 Z"/>
            <rect x="9" y="11" width="6" height="5" rx="1" fill="currentColor" stroke="none"/>
            <path d="M10 11 V9.5 A2 2 0 0 1 14 9.5 V11"/>
            </svg>
        </div>

        <h1 id="modalTitle">[[title]]</h1>
        <p class="subtitle">To help us prevent spam, please solve the question below.</p>
        <div class="question-box">
            <p>[[message]]</p>
        </div>
        [[content]]
        [[footer]]
    </div>
    {literal}
        <style>
            :root{
                --overlay-bg: rgba(30, 34, 46, 0.55);
                --modal-bg: #ffffff;
                --text-dark: #131a2e;
                --text-muted: #6b7280;
                --accent-blue: #4640de;
                --accent-blue-hover: #3b35c9;
                --icon-blue: #4640de;
                --icon-bg: #eef0fd;
                --input-border: #e5e7eb;
                --success-green: #22c55e;
                --shadow: 0 25px 60px -12px rgba(20, 20, 43, 0.35);
            }

            @keyframes pop-in {
                from { opacity: 0; transform: translateY(10px) scale(0.98); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }
            .swal2-icon {
                display: none !important;
            }
            /* Icon */
            .icon-wrap {
                width: 120px;
                height: 120px;
                margin: 0 auto 24px;
                border-radius: 50%;
                background: var(--icon-bg);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            .icon-wrap svg.shield {
                width: 56px;
                height: 56px;
                color: var(--icon-blue);
            }

            .sparkle {
                position: absolute;
                color: #c7cdfb;
            }
            .sparkle.s1 { width: 14px; height: 14px; top: 8px; right: 4px; }
            .sparkle.s2 { width: 20px; height: 20px; top: 30px; right: -14px; }
            .sparkle.s3 { width: 10px; height: 10px; bottom: 18px; left: 2px; }
            .sparkle.s4 { width: 8px; height: 8px; bottom: 0px; left: -10px; }

            /* Heading */
            h1 {
                font-size: 30px;
                font-weight: 800;
                color: var(--text-dark);
                margin: 0 0 10px;
                letter-spacing: -0.01em;
            }

            .subtitle {
                font-size: 16px;
                color: var(--text-muted);
                margin: 0 0 28px;
                line-height: 1.5;
            }

            /* Question box */
            .question-box {
                border: 1px solid var(--input-border);
                border-radius: 16px;
                padding: 22px 20px;
                margin-bottom: 16px;
            }

            .question-box p {
                margin: 0;
                font-size: 19px;
                font-weight: 700;
                color: var(--text-dark);
            }

            .question-box .num {
                color: var(--accent-blue);
            }

            /* Answer input */
            .answer-wrap {
                position: relative;
                margin-bottom: 24px;
            }

            .answer-input {
                width: 100%;
                font-size: 18px;
                padding: 16px 50px 16px 20px;
                border: 1px solid var(--input-border);
                border-radius: 14px;
                outline: none;
                color: var(--text-dark);
                background: #fff;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
            }

            .answer-input:focus {
                border-color: var(--accent-blue);
                box-shadow: 0 0 0 3px rgba(70, 64, 222, 0.15);
            }

            .check-icon {
                position: absolute;
                right: 16px;
                top: 50%;
                transform: translateY(-50%);
                width: 26px;
                height: 26px;
                color: var(--success-green);
            }

            /* Buttons */
            .btn-row {
                display: flex;
                gap: 14px;
                margin-bottom: 24px;
            }

            .btn {
                flex: 1;
                padding: 16px 20px;
                font-size: 16px;
                font-weight: 700;
                border-radius: 14px;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: background-color 0.15s ease, transform 0.05s ease;
            }

            .btn:active { transform: scale(0.98); }

            .btn-verify {
                background: var(--accent-blue);
                color: #fff;
            }
            .btn-verify:hover { background: var(--accent-blue-hover); }

            .btn-verify svg {
                width: 16px;
                height: 16px;
            }

            .btn-cancel {
                background: #fff;
                color: #374151;
                border: 1px solid var(--input-border);
            }
            .btn-cancel:hover { background: #f9fafb; }

            /* Footer note */
            .footer-note {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                font-size: 14px;
                color: var(--text-muted);
            }

            .footer-note svg {
                width: 18px;
                height: 18px;
                color: var(--accent-blue);
                flex-shrink: 0;
            }

            /* ===== Mobile ===== */
            @media (max-width: 560px) {
                .overlay { padding: 0; align-items: flex-end; }

                .modal {
                max-width: 100%;
                width: 100%;
                border-radius: 24px 24px 0 0;
                padding: 36px 24px 32px;
                animation: slide-up 0.25s ease-out;
                }

                @keyframes slide-up {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
                }

                .icon-wrap {
                width: 96px;
                height: 96px;
                margin-bottom: 20px;
                }
                .icon-wrap svg.shield { width: 46px; height: 46px; }

                h1 { font-size: 24px; }
                .subtitle { font-size: 14px; margin-bottom: 22px; }

                .question-box { padding: 18px 16px; }
                .question-box p { font-size: 17px; }

                .answer-input { font-size: 16px; padding: 14px 46px 14px 16px; }

                .btn-row { flex-direction: column; gap: 12px; }
                .btn { padding: 15px 18px; }

                .footer-note { font-size: 13px; }
            }

            @media (max-width: 360px) {
                .modal { padding: 28px 18px 26px; }
                h1 { font-size: 21px; }
            }
        </style>
    {/literal}
</script>