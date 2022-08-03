<?php
$status_text = '';
switch ( $_POST['action'] ?? '' ) {
	case 'test':
		touch( __DIR__ . '/.test-again' );
		$status_text = "Test run requested.";
		break;
	case 'approve':
		if ( file_exists( __DIR__ . '/.test-again' ) ) break;
		touch( __DIR__ . '/.action-approve' );
		$status_text = "Change approval noted.";
		break;
}
?>
<html>
<head>
<meta http-equiv="refresh" content="30"/>
<style>
html {
	background-color: #E2E7EA;
}
h1 {
	display: inline;
}
.actions {
	float: right;
	padding-right: 1em;
}
.actions button {
	padding: 1em;
	margin-left: 1em;
	border: none;
	border-radius: 3px;
	box-shadow: 0 3px 6px 0 rgb(0 0 0 / 16%);
}
.actions button:hover {
	cursor: hand;
	box-shadow: 0 4px 5px 0 rgb(0 0 0 / 14%), 0 1px 10px 0 rgb(0 0 0 / 12%), 0 2px 4px -1px rgb(0 0 0 / 30%);
}
.actions button.approve {
	background-color: #8BC34A;
	color: white;
}
</style>
</head>
<body>
	<form class="actions" method="POST">
		<?php
		if ( $status_text ) {
			echo "<strong>$status_text</strong>";
		}

		if ( file_exists( './logs' )  && false ) {
			?>
			<button class="logs" onclick="">View Logs</button>
			<?php
		}
		?>

		<button type="submit" class="run" name="action" value="test">Run again</button>
		<button type="submit" class="approve" name="action" value="approve">Approve all</button>
	</form>
	<h1>Dion's WordPress.org BackstopJS Instance</h1>
	<?php
		$last_run = filemtime( __DIR__ . '/backstop_data/html_report/index.html' );
		$last_run_text = gmdate( 'Y-m-d H:i:s', $last_run );
		if ( ( time() - $last_run ) / 60 < 3*60 ) {
			$last_run_text = floor( ( time() - $last_run ) / 60 ) . ' minutes ago';
		}

	?>
	Last Run: <em><?php echo $last_run_text; ?></em>
	<?php
		if ( file_exists(  __DIR__ . '/.test-again' ) ) {
			echo '<strong>Waiting for test run to complete...</strong>';
		}
	?>
</body>
</html>
