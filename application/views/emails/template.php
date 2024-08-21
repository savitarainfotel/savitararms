<!doctype html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
        <style>
            html{
                font-family: 'Montserrat', sans-serif;
            }
            .btn-primary {
                background: #365caa;
                color: #ffffff !important;
                font-family: 'Montserrat', sans-serif;
                font-size: 15px;
                font-weight: normal;
                line-height: 120%;
                margin-top: 1rem;
                text-decoration: none;
                text-transform: none;
                border: none;
                border-radius: 3px;
                cursor: auto;
                padding: 15px 25px;
                display: inline-table;
            }
            .btn-danger {
                background: #d9534f;
                color: #ffffff !important;
                font-family: 'Montserrat', sans-serif;
                font-size: 15px;
                font-weight: normal;
                line-height: 120%;
                margin-top: 1rem;
                text-decoration: none;
                text-transform: none;
                border: none;
                border-radius: 3px;
                cursor: auto;
                padding: 15px 25px;
                display: inline-table;
            }
            .table table {
                table-layout: fixed;
                width: 100%;
            }

            th {
                font-weight: 400 !important;
            }
        </style>
    </head>
    <body>
        <table style="background-color:#f9f9f9;width:100%;">
            <tbody>
                <tr>
                    <div style="background-color:#f9f9f9;">
                        <div style="background-color:#f9f9f9;Margin:0px auto;max-width:900px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#f9f9f9;width:100%;">
                                <tbody>
                                    <tr>
                                        <td style="font-family: 'Montserrat', sans-serif; border-bottom:#365caa solid 5px;direction:ltr;padding:20px 0;text-align:center;vertical-align:top;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="background:#fff;background-color:#fff;Margin:0px auto;max-width:900px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#fff;background-color:#fff;width:100%;">
                                <tbody>
                                    <tr>
                                        <td style="border:#dddddd solid 1px;border-top:0px;direction:ltr;padding:20px 0;text-align:left;vertical-align:top;">
                                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:bottom;width:100%;">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:bottom;" width="100%">
                                                    <tr>
                                                        <td align="center" style="font-family: 'Montserrat', sans-serif; padding:10px 25px;">
                                                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <img height="auto" src="<?= base_url('assets/images/logo.png') ?>" style="border:0;display:block;outline:none;text-decoration:none;width:100%;" />
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="padding:10px 25px;">
                                                            <div style="font-family: 'Montserrat', sans-serif; font-size:15px; line-height:1.5;text-align:left;color:#555;">
                                                                <?php echo $content; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                            <div style="font-family:'Montserrat',Arial,sans-serif;font-size:14px;line-height:20px;text-align:left;color:#525252;">
                                                                <p>Regards, <?= APP_NAME; ?></p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="Margin:0px auto;max-width:900px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td style="direction:ltr;padding:20px 0;text-align:left;vertical-align:top;">
                                            <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:bottom;width:100%;">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="vertical-align:bottom;padding:0;">
                                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                                                    <tr>
                                                                        <td align="center" style="padding:0;">
                                                                            <div style="font-family:'Montserrat',Arial,sans-serif;font-size:12px;font-weight:300;line-height:1;text-align:center;color:#575757;">
                                                                                <?= APP_NAME; ?> @ Copyright 2024
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </tr>
            </tbody>
        </table>
    </body>
</html>