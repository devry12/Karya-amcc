<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
</head>
<body>
  <style media="screen">
    .custom{
      width: 80%;
      margin: 5% auto;
      height: 80%;
    }
  </style>

  <div class="">
    <a href='<?php echo site_url('admin/wait')?>'>Post Menunggu</a> |
    <a href='<?php echo site_url('admin/publish')?>'>Post Publish</a> |
  </div>
  <div class="custom">
		<?php echo $output; ?>
  </div>

    <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
</body>
</html>
