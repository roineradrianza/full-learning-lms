<body
    style='background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body'
        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);'>
        <tr>
            <td style='font-size: 16px; vertical-align: top;'>&nbsp;</td>
            <td class='container'
                style='font-size: 16px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;'>
                <div class='content'
                    style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

                    <!-- START CENTERED WHITE CONTAINER -->
                    <table class='main'
                        style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;'>
                        <td style="display: flex;">
                            <img src='https://full-learning.com/public/img/logo.png'
                                style="width:35%; max-width: 200px; margin:auto;"></img>
                        </td>
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper'
                                style=' font-size: 16px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
                                <table border='0' cellpadding='0' cellspacing='0'
                                    style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                                    <tr>
                                        <td style='font-size: 16px; vertical-align: top;'>
                                            <p style="text-align: center">
                                                La orden de pago ha sido aprobada. 
                                            </p>
                                            <p style="text-align: center">
                                                <span
                                                    style="color: #3d0235;font-weight: bold;">
                                                        Orden: 
                                                </span>
                                                <?php echo $order_id ?>
                                            </p>
                                            <p style="text-align: center">
                                                <span
                                                    style="color: #3d0235;font-weight: bold;">
                                                    <?php if ($type == 1) : ?>
                                                        Curso: 
                                                    <?php elseif ($type == 2) : ?>
                                                        Descripci??n: 
                                                    <?php endif ?>
                                                </span>
                                                <?php echo $meta['course'] ?>
                                            </p>

                                            <p style="text-align: center"><span
                                                    style="color: #3d0235;font-weight: bold;">Monto:</span>
                                                <?php echo '$' . $total_pay ?></p>

                                            <a href="<?php echo SITE_URL . "/courses/{$course['slug']}"?>"
                                                style="display: block; color: #ffffff; background-color: #003146; border: solid 1px #003146; margin-top:30px;border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 16px; font-weight: bold; margin: 0; border-color: #003146;">
                                                <p style='text-align: center;'>Ir al curso</p>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- END MAIN CONTENT AREA -->
                    </table>

                    <!-- END CENTERED WHITE CONTAINER -->
                </div>
            </td>
        </tr>
    </table>
</body>