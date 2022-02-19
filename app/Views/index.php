<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Kamar</title>
    <link rel="shorcut icon" href="<?= base_url('icon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/app.bundle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome/css/all.min.css') ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css">
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <div id="app">
    </div>
    <script>
        let base_url = '<?= base_url() ?>/';
        
        let print = (selector) => {
            const originalBody = document.body.innerHTML;
            const printview = document.querySelector(selector).innerHTML;
            document.body.innerHTML = printview;
            setTimeout(() => {
                window.print();
                document.body.innerHTML = originalBody;
            }, 200);
        }
    </script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>
    <script src="<?= base_url('dist/app.bundle.js') ?>"></script>
</body>
</html>