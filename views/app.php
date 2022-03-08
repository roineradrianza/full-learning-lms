<!DOCTYPE html>
<html id="preload" class="preload" lang="ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Si tu propósito es aprender el nuestro es que lo hagas excelente. Aprende desde cero a crear el futuro web con nuestros Cursos Online Profesionales." />
    <meta property="og:site_name" content="<?php echo $title ?>">
    <meta property="og:title" content="<?php echo $title ?>" />
    <meta property="og:description" content="Si tu propósito es aprender el nuestro es que lo hagas excelente." />
    <meta property="og:image" itemprop="image" content="<?php echo SITE_URL ?>/public/img/og-cover-2.jpg">
    <meta property="og:type" content="website" />
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo SITE_URL ?>/public/favicon/favicon.ico">
    <link href="<?php echo SITE_URL ?>/public/css/material-design-icons.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL ?>/public/css/vuetify.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL ?>/public/css/app-v1.0.0.min.css" rel="stylesheet">
    <?php if (!empty($data['styles'])) : ?>
        <?php foreach ($data['styles'] as $style) : ?>
            <?php if (isset($style['external']) and $style['external']) : ?>
                <link href="<?php echo $style['url']; ?>" rel="stylesheet">
            <?php else : ?>
                <link href="<?php echo SITE_URL ?>/public/assets/css/<?php echo $style['name']; ?>.css" rel="stylesheet">

            <?php endif ?>

        <?php endforeach ?>
    <?php endif ?>
</head>

<body class="body-preload">
    <?php echo new Template('parts/preloader') ?>
    <div id="full-learning-container">
        <!-- Sizes your content based upon application components -->
        <v-app class="preloading" light>
            <!-- Provides the application the proper gutter -->
            <?php if ($data['header']) : ?>
                <?php echo new Template('parts/header') ?>
                <?php echo new Template('parts/subheader') ?>
            <?php endif ?>
            <?php if ($data['admin_header']) : ?>
                <?php echo new Template('admin/parts/header') ?>
            <?php endif ?>
            <v-main>
                <v-container fluid>
                    <?php if ($data['nav']) : ?>
                        <?php echo new Template('parts/nav') ?>
                    <?php endif ?>
                    <?php echo $content; ?>
                </v-container fluid>
            </v-main>
            <?php if ($data['footer']) : ?>
                <?php echo new Template('parts/footer') ?>
            <?php endif ?>

        </v-app>
    </div>
    <?php if (isset($_SESSION['user_id'])) : ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <?php if ($_SESSION['user_type'] != 'administrador') : ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-TZSZ1X8SC9"></script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());

                gtag('config', 'G-TZSZ1X8SC9');
            </script>
        <?php endif ?>
        <script>
            <?php $id = (string) $_SESSION['user_id']; ?>
            var uid = "<?php echo Helper::encrypt($id); ?>"
            const basic_info = {
                first_name: "<?php echo $_SESSION['first_name'] ?>",
                last_name: "<?php echo $_SESSION['last_name'] ?>",
                email: "<?php echo $_SESSION['email'] ?>",
                telephone: "<?php echo !empty($_SESSION['meta']['telephone']) ? $_SESSION['meta']['telephone'] : '' ?>",
            }
        </script>
    <?php endif ?>
    <script src="https://apis.google.com/js/api.js"></script>
    <script src="<?php echo SITE_URL ?>/public/js/preload.js"></script>
    <?php if (DEV_ENV) : ?>
        <script src="<?php echo SITE_URL ?>/public/js/vue.js"></script>
    <?php else : ?>
        <script src="<?php echo SITE_URL ?>/public/js/vue.pmin.js"></script>
    <?PHP endif ?>

    <script src="<?php echo SITE_URL ?>/public/js/components/vuetify.min.js"></script>
    <script src="<?php echo SITE_URL ?>/public/js/components/vue-resource.min.js"></script>
    <script src="<?php echo SITE_URL ?>/public/js/theme.js"></script>
    <script src="<?php echo SITE_URL ?>/public/js/setup.js"></script>
    <?php if (!empty($data['scripts'])) : ?>
        <?php foreach ($data['scripts'] as $script) : ?>
            <?php if (isset($script['external']) && $script['external']) : ?>

                <script src="<?php echo $script['name']; ?>" <?php if (isset($data['props'])) echo $data['props'] ?>></script>

            <?php else : ?>

                <script src="<?php echo SITE_URL ?>/public/assets/js/<?php echo $script['name']; ?>.js<?php echo !empty($script['version']) ? "?v={$script['version']}" : '' ?>">
                </script>

            <?php endif ?>

        <?php endforeach ?>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <script src="<?php echo SITE_URL ?>/public/assets/js/notifications.min.js?v=v1.0.0"></script>
        <?php endif ?>

    <?php else : ?>
        <script src="<?php echo SITE_URL ?>/public/js/main.js"></script>
    <?php endif ?>

</body>

</html>