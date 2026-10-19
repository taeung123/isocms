<div class="tm-subcard" style="margin-top:24px;">
    <div class="tm-subcard__header">
        <div class="tm-subcard__heading">
            <span class="tm-subcard__icon" aria-hidden="true">
                <i class="fa-solid fa-code"></i>
            </span>

            <div class="tm-subcard__titles">
                <strong>Schema Markup (JSON-LD)</strong>
                <p>
                    Custom Schema in JSON format and adds schema to the page
                    in addition to the default schemas.
                </p>
            </div>
        </div>

        <a href="#" class="tm-link" id="lnkSchemaExample">
            Example
        </a>
    </div>

    <textarea
    id="schemaMarkup"
    name="iso-schema_markup"
    class="tm-code-area"
    spellcheck="false"
    placeholder='{
  "@context": "https://schema.org",
  "@type": "TouristTrip",
  "name": "Your tour name",
  "description": "Your tour description"
}'>{if !empty($schema_markup)}{$schema_markup}{/if}</textarea>

    <div id="schema_validate_message"></div>

    <button type="button" class="tm-btn tm-btn--validate" id="btnValidateSchema" style="margin-top:12px;">
        <i class="fa-solid fa-check"></i>
        Validate Schema
    </button>
</div>

{literal}
    <script>
        $(function() {

            /* =========================================================
         * SCHEMA EXAMPLE
         * ========================================================= */
            $('#lnkSchemaExample').on('click', function(e) {
                e.preventDefault();

                var example = {
                    "@context": "https://schema.org",
                    "@type": "TouristTrip",
                    "name": "5 Days Discovering the Imperial and Coastal Charms of Central Vietnam",
                    "description": "Explore the imperial heritage of Central Vietnam..."
                };

                $('#schemaMarkup').val(
                    JSON.stringify(example, null, 2)
                );

                $('#schema_validate_message').html('');
            });


            /* =========================================================
         * SHOW VALIDATION ERROR
         * ========================================================= */
            function showSchemaError(message) {
                $('#schema_validate_message').html(
                    '<div class="schema-message schema-message--error">' +
                    message +
                    '</div>'
                );
            }


            /* =========================================================
         * SHOW VALIDATION WARNING
         * ========================================================= */
            function showSchemaWarning(message) {
                $('#schema_validate_message').html(
                    '<div class="schema-message schema-message--warning">' +
                    message +
                    '</div>'
                );
            }


            /* =========================================================
         * SHOW VALIDATION SUCCESS
         * ========================================================= */
            function showSchemaSuccess(message) {
                $('#schema_validate_message').html(
                    '<div class="schema-message schema-message--success">' +
                    message +
                    '</div>'
                );
            }


            /* =========================================================
         * VALIDATE SCHEMA
         * ========================================================= */
            $('#btnValidateSchema').on('click', function() {

                var value = $('#schemaMarkup').val().trim();

                /* -----------------------------------------------------
             * Empty
             * ----------------------------------------------------- */
                if (!value) {
                    showSchemaWarning('Schema đang trống.');
                    return;
                }


                var data;


                /* -----------------------------------------------------
             * Check JSON syntax
             * ----------------------------------------------------- */
                try {
                    data = JSON.parse(value);
                } catch (e) {

                    showSchemaError(
                        'JSON không hợp lệ: ' + e.message
                    );

                    return;
                }


                /* =====================================================
             * CASE 1:
             * Schema sử dụng @graph
             * ===================================================== */
                if (
                    data &&
                    typeof data === 'object' &&
                    !Array.isArray(data) &&
                    data.hasOwnProperty('@graph')
                ) {

                    /* Check @context */
                    if (!data['@context']) {
                        showSchemaError(
                            'Schema sử dụng @graph nhưng thiếu @context.'
                        );
                        return;
                    }


                    /* Check @graph */
                    if (
                        !Array.isArray(data['@graph']) ||
                        data['@graph'].length === 0
                    ) {
                        showSchemaError(
                            '@graph phải là một mảng và không được để trống.'
                        );
                        return;
                    }


                    /* Check từng schema trong @graph */
                    for (var i = 0; i < data['@graph'].length; i++) {

                        var item = data['@graph'][i];

                        if (
                            !item ||
                            typeof item !== 'object' ||
                            Array.isArray(item)
                        ) {
                            showSchemaError(
                                'Schema trong @graph #' +
                                (i + 1) +
                                ' không hợp lệ.'
                            );
                            return;
                        }


                        if (!item['@type']) {
                            showSchemaError(
                                'Schema trong @graph #' +
                                (i + 1) +
                                ' thiếu @type.'
                            );
                            return;
                        }
                    }


                    showSchemaSuccess(
                        'Schema hợp lệ. Đã kiểm tra ' +
                        data['@graph'].length +
                        ' schema trong @graph.'
                    );

                    return;
                }


                /* =====================================================
             * CASE 2:
             * Schema đơn
             * ===================================================== */
                if (
                    data &&
                    typeof data === 'object' &&
                    !Array.isArray(data) &&
                    (
                        data.hasOwnProperty('@context') ||
                        data.hasOwnProperty('@type')
                    )
                ) {

                    /* Check @context */
                    if (!data['@context']) {
                        showSchemaError(
                            'Schema thiếu @context.'
                        );
                        return;
                    }


                    /* Check @type */
                    if (!data['@type']) {
                        showSchemaError(
                            'Schema thiếu @type.'
                        );
                        return;
                    }


                    showSchemaSuccess(
                        'Schema hợp lệ: ' +
                        data['@type'] +
                        '.'
                    );

                    return;
                }


                /* =====================================================
             * CASE 3:
             * JSON Array chứa nhiều schema
             * ===================================================== */
                if (!Array.isArray(data)) {

                    showSchemaError(
                        'Schema phải là JSON Object hoặc JSON Array.'
                    );

                    return;
                }


                /* Empty array */
                if (data.length === 0) {

                    showSchemaError(
                        'Danh sách Schema đang trống.'
                    );

                    return;
                }


                /* Check từng schema */
                for (var j = 0; j < data.length; j++) {

                    var schema = data[j];

                    if (
                        !schema ||
                        typeof schema !== 'object' ||
                        Array.isArray(schema)
                    ) {

                        showSchemaError(
                            'Schema #' +
                            (j + 1) +
                            ' không hợp lệ.'
                        );

                        return;
                    }


                    if (!schema['@context']) {

                        showSchemaError(
                            'Schema #' +
                            (j + 1) +
                            ' thiếu @context.'
                        );

                        return;
                    }


                    if (!schema['@type']) {

                        showSchemaError(
                            'Schema #' +
                            (j + 1) +
                            ' thiếu @type.'
                        );

                        return;
                    }
                }


                /* Success */
                showSchemaSuccess(
                    'Schema hợp lệ. Đã kiểm tra ' +
                    data.length +
                    ' schema.'
                );
            });

        });
    </script>


    <style>
        /* schema markup sub-card */
        .tm-subcard {
            border: 1px solid var(--color-border-light);
            border-radius: var(--border-radius-lg);
            padding: 16px;
        }

        .tm-subcard__header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .tm-subcard__heading {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .tm-subcard__icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: var(--color-primary-soft);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .tm-subcard__titles strong {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--color-text);
        }

        .tm-subcard__titles p {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        .tm-link {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--color-primary);
            text-decoration: none;
            flex-shrink: 0;
        }

        .tm-link:hover {
            color: var(--color-primary-dark);
        }

        .tm-code-area {
            width: 100%;
            min-height: 140px;
            border-radius: var(--border-radius-md);
            border: 1px solid var(--color-border);
            background: var(--color-page);
            padding: 12px 14px;
            font-family: "SFMono-Regular", Consolas, monospace;
            font-size: 12.5px;
            line-height: 1.6;
            color: var(--color-text);
            resize: vertical;
        }

        .tm-code-area:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .schema-message {
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 13px;
            line-height: 1.5;
        }
        .tm-btn--validate {
            background: var(--color-primary);
            color: #fff;
            height: 40px;
            padding: 0 16px;
        }
        .tm-btn--validate:hover {
            background: var(--color-primary-dark);
        }

        .schema-message--error {
            color: #b42318;
            background: #fef3f2;
            border: 1px solid #fecdca;
        }

        .schema-message--warning {
            color: #b54708;
            background: #fffaeb;
            border: 1px solid #fedf89;
        }

        .schema-message--success {
            color: #027a48;
            background: #ecfdf3;
            border: 1px solid #abefc6;
        }
        
    </style>
{/literal}