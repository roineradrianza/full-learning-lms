
<body style='background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
    <table border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: linear-gradient(to right, rgba(0,49,70,1) 0%, rgba(61,2,53,1) 100%);'>
      <tr>
        <td class='container' style='font-size: 16px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;'>
          <div class='content' style='box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;'>

            <!-- START CENTERED WHITE CONTAINER -->
            <table class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;'>
              <tr>
                <td style="display: flex;">
                  <a href="<?php echo SITE_URL ?>" style="width:35%; max-width: 200px; margin:auto;">
                    <img src='https://full-learning.com/public/img/logo.png' style="width:100%;"></img>                
                  </a>
                </td>
              </tr>
              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class='wrapper' style=' font-size: 16px; vertical-align: top; box-sizing: border-box; padding: 20px;'>
                  <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;'>
                    <tr>
                      <td style='font-size: 16px; vertical-align: top;'>
                        <?php echo $data['content'] ?>
                        <p>
                          Para iniciar sesión, utiliza las siguientes credenciales: <br>
                          <span><b>Email:</b><?php echo $data['email'] ?></span>
                          <br>
                          <span><b>Contraseña:</b><?php echo $data['password'] ?></span>
                          <br>
                          <br>
                          <span>Puedes cambiar tu contraseña al iniciar sesión y completar el formulario de registro.</span>   
                        </p>
                        <p style="text-align: center;">
                          Debajo de este texto, encontrarás el código del cupón de descuento del <b><?php echo $data['coupon_discount'] ?></b>, ingresalo en el curso <a href="<?php echo SITE_URL ?>/courses/<?php echo $data['course']['slug'] ?>" style="color: #3d0235;"><b>"<?php echo $data['course']['title'] ?>"</b> <span style="color: #003146;">(puedes ir al curso haciendo click al título del mismo)</span></a>
                        </p>
                        <div style="color: #ffffff; background-color: #003146; border: solid 1px #003146; margin-top:30px;border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 16px; font-weight: bold; margin: 0; border-color: #003146;">
                          <p style='text-align: center;'><?php echo $data['coupon_code'] ?></p>
                        </div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <?php if (!empty($data['course_sponsors'])): ?>
              <tr>
                <td style="display: flex;">
                  <img src='<?php echo $data['course_sponsors']['course_meta_val'] ?>' style="width:100%; max-width: 95%; margin:auto"></img>
                </td>
              </tr>
              <?php endif ?>
            <!-- END MAIN CONTENT AREA -->
            </table>
          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
      </tr>
  </table>
</body>