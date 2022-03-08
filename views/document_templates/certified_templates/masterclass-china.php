<style type="text/css">
@page {
    margin: 2.5%;
    background-image: url('<?php echo DIRECTORY; ?>/public/img/certificado-bg-02-no-bt.png');

}

h1,
h2,
h3,
h4,
h5,
h6 {
    font-weight: 400 !important;
}

header {
    position: inline-block;
}

.container {
    border: 4px solid #003146;
    height: 1150px
}

.title {
    clear: both;
}

.certified-title,
.certified-subtitle {
    font-family: 'constantia';
}

.certified-title {
    font-size: 35pt;
}

.certified-subtitle {
    font-size: 25pt;
}

.full-name {
    font-family: 'greatvibes' !important;
    font-size: 50pt;
    color: #003146;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.text-uppercase {
    text-transform: uppercase;
}

.titleDesc {
    color: #003146;
}

.titles {
    margin-top: -20px;
}
</style>

<body>
    <div class="container" style=" 
        <?php if (count(explode(' ', $data['first_name'] . ' ' . $data['last_name'])) > 3): ?>
        margin-bottom: -550px
        <?php else: ?>
        margin-bottom: -650px
        <?php endif ?>
    ">
        <header>
            
            <div style="width:60%" align="left">
                <img src="<?php echo DIRECTORY; ?>/public/img/certified-assets/masterclass-china/cedees-logo.png" width="350px">
            </div>
            <div style="width:100%; margin-top: -130px" align="right">
                <img src="<?php echo DIRECTORY; ?>/public/img/logo.png" width="110px">
            </div>
        </header>
        <div style="width:100%;">
            <h2 class="certified-title text-uppercase text-center" style="margin-top: 70px; margin-bottom: -30px;">Certificado
            </h2>
        </div>
        <div style="width:100%;margin-bottom: -65px;">
            <h3 class="text-center" style="font-size: 20pt;"><b>Otorgado a</b></h3>
        </div>
        <div style="width:100%;margin-bottom: -100px; padding: 0px 15px 0px 15px">
            <h3 class="full-name text-center"><?php echo $data['first_name'] ?> <?php echo $data['last_name'] ?></h3>
        </div>
        <div style="width: 100%; margin-top:-85px;">
            <h4 class="text-center" style="color:#9C9B9B;font-family:arial !important;font-size: 14pt;">
                Por haber aprobado
                    <br>
                    <b style="font-size: 16pt;">“Masterclass sobre China”</b> del
                    <br>
                    Centro de Altos Estudios del Desarrollo y Las Economías Emergentes
                
            </h4>
        </div>
        <div>
            <div style="width: 100%;">
                <div style="width:100%" align="left">
                    <div align="left" style="margin-left: 10%; margin-top: 40px;">
                        <img src="<?php echo DIRECTORY; ?>/public/img/certified-assets/masterclass-china/masterclass-china-firma-1.jpg"
                            style="border-bottom: 1.7px solid black" width="140px">
                    </div>

                    <div style="margin-left: 9.5%" align="left">
                        <h4 style="font-family: arial !important; font-size: 14pt;"><b>Andreína Tarazón</b></h4>
                    </div>

                    <div align="left" style="width:90%; margin-left: 60px; margin-top: -25px;">
                        <img src="<?php echo DIRECTORY; ?>/public/img/certified-assets/masterclass-china/cedees-sello.png"
                            width="170px">
                    </div>
                </div>
            </div>
            <div style="width: 100%; margin-top: -310px">
                <div style="width:100%" align="right">
                    <div align="right" style="width:90%">
                        <img src="<?php echo DIRECTORY; ?>/public/img/certified-assets/masterclass-china/masterclass-china-firma-2.jpg"
                        style="border-bottom: 1.7px solid black" width="140px">
                    </div>

                    <div style="width:87.5%" align="right">
                        <h4 style="font-family: arial !important; font-size: 14pt; text-align: right"><b>Luis
                                Delgado</b></h4>
                    </div>
                    
                    <div align="right" style="width:90%; margin-left: 15px; margin-top: -25px;">
                        <img src="<?php echo DIRECTORY; ?>/public/img/certified-assets/masterclass-china/cedees-sello-2.png"
                         width="170px">
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>