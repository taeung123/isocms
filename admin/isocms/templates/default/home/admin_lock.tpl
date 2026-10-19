<div class="container mt-5">
    <div class="emergency-form bg-light p-5 rounded shadow-sm">
        <h2 class="text-center mb-4">{$core->get_Lang('Emergency admin page lock')}!</h2>
        <div class="alert alert-warning text-center">
            <p>{$core->get_Lang('Choose value = "0" to open the admin page')}</p>
            <p>{$core->get_Lang('Choose value = "1" to lock the emergency admin page')}</p>
            <p>{$core->get_Lang('If you do not select an admin lock time, by default it will be locked immediately')}</p>
        </div>
        <form method="POST">
            <div class="mb-3">
                <label for="lockDate" class="form-label">
                    {$core->get_Lang('Choose value')}
                </label>
                <div class="form-check mb-3">
                    <input type="radio" class="form-check-input" id="option1"
                           name="iso-cfg_lock_admin"
                           value="0" {if $clsConfiguration->getValue('cfg_lock_admin') == 0} checked{/if}>
                    <label class="form-check-label" for="option1">0</label>
                </div>
                <div class="form-check mb-4">
                    <input type="radio" class="form-check-input" id="option2"
                           name="iso-cfg_lock_admin"
                           value="1" {if $clsConfiguration->getValue('cfg_lock_admin') == 1} checked{/if}>
                    <label class="form-check-label" for="option2">1</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="lockDate" class="form-label">
                    {$core->get_Lang('Set admin lockout time')}
                </label>
                <input value="{$clsISO->formatTimeMonth($clsConfiguration->getValue('cfg_lock_admin_date'))}"
                       class="form-control showdate"
                       name="cfg_lock_admin_date" type="text" id="lockDate" autocomplete="off"
                       onClick="loadHelp(this), showDatepicker(this)"/>
            </div>
            <input type="hidden" name="hid_lock_admin" value="hid_lock_admin">
            <button type="submit" class="btn btn-danger w-100">{$core->get_Lang('Submit')}</button>
        </form>
    </div>
</div>

{literal}
    <style>
        .emergency-form {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .form_radio {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .form-check-label {
            margin-bottom: unset;
            cursor: pointer;
        }

        .form-check-input {
            margin-top: unset !important;
            cursor: pointer;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .showdate {
            width: 50%;
        }
    </style>
    <script>
        $(".showdate").datepicker({
            dateFormat: "dd/mm/yy"
        });
        $(document).ready(function () {
            $('#option1').click(function () {
                $('#lockDate').val('').prop('disabled', true).css('background-color', '#f0f0f0');
            });
            $('#option2').click(function () {
                $('#lockDate').prop('disabled', false).css('background-color', '');
            });

            // Ensure the initial state is correct based on which option is checked
            if ($('#option1').is(':checked')) {
                $('#lockDate').prop('disabled', true).css('background-color', '#f0f0f0');
            } else if ($('#option2').is(':checked')) {
                $('#lockDate').prop('disabled', false).css('background-color', '');
            }
        });
    </script>
{/literal}
