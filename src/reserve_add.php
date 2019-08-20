<?php
include_once 'env.php';
include_once 'common.php';
//TODO HTMLのテンプレ化
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
	 crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
	 crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
	 crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<title>予約管理システム/予約登録</title>
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="container-fluid">
		<nav class="navbar navbar-expand navbar-light">
			<span class="navbar-brand">予約管理システム</span>
			<ul class="navbar-nav text-nowrap">
				<li class="nav-item">
					<a class="nav-link" href="#">TOP</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link active" href="reserve.php">予約一覧</a>
				</li>
			</ul>
		</nav>
		<form method="POST" id="reserve_form">
			<div class="row my-2">
				<div class="col-md-2 text-md-right">
					<label for="phone_no">
						電話番号
						<i class="fas fa-phone"></i>
					</label>
				</div>
				<div class="col-md-10">
					<input type="text" class="w-75" id="phone_no" name="phone_no" placeholder="09012345678" value="" required>
					<span class="badge badge-pill badge-secondary">必須</span>
				</div>
			</div>
			<div class="row my-2">
				<div class="col-md-2 text-md-right">
					<label for="client_name">
						お名前
						<i class="fas fa-user"></i>
					</label>
				</div>
				<div class="col-md-10">
					<input type="text" class="w-75" id="client_name" name="client_name" placeholder="お名前" value="" required>
					<span class="badge badge-pill badge-secondary">必須</span>
				</div>
			</div>

			<div class="row my-2">
				<div class="col-md-2 text-md-right">
					<label for="reserve_date">
						予約日
						<i class="far fa-calendar-alt"></i>
					</label>
				</div>
				<div class="col-md-10">
					<input type="text" class="datepicker w-75" id="reserve_date" name="reserve_date" placeholder="YYYY-MM-DD" value="" autocomplete="off" required>
					<span class="badge badge-pill badge-secondary">必須</span>
				</div>
			</div>

			<div class="row my-2">
				<div class="col-md-2 text-md-right">
					<label for="reserve_time">
						予約時刻
						<i class="far fa-clock"></i>
					</label>
				</div>

				<div class="col-md-8">
					<select class="timepicker w-25" id="reserve_time_from" name="reserve_time_from" required>
<?php output_time(); ?>
					</select>
					&nbsp;～&nbsp;
					<select class="timepicker w-25" id="reserve_time_to" name="reserve_time_to" required>
<?php output_time(); ?>
					</select>
					<span class="badge badge-pill badge-secondary">必須</span>
				</div>
			</div>

			<div class="row my-2">
				<div class="col-md-2 text-md-right">
					<label for="reserve_quantity">
						人数
						<i class="fas fa-users"></i>
					</label>
				</div>
				<div class="col-md-8">
					<input type="text" class="w-25 text-right" id="reserve_quantity" name="reserve_quantity" placeholder="" value="" required>&nbsp;人
					<span class="badge badge-pill badge-secondary">必須</span>
				</div>
			</div>

			<div class="row my-1">
				<div class="col-md-2 text-md-right">
					<label>
						席タイプ
						<i class="fas fa-chair"></i>
					</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_type_0" name="seat_type" value="none"><label for="seat_type_0">指定なし</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_type_1" name="seat_type" value="box"><label for="seat_type_1">ボックス席</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_type_2" name="seat_type" value="counter"><label for="seat_type_2">カウンター席</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_type_3" name="seat_type" value="table"><label for="seat_type_3">テーブル席</label>
				</div>
				<div class="col-md-auto"></div>
			</div>

			<div class="row my-1">
				<div class="col-md-2 text-md-right">
					<label>
						喫煙
						<i class="fas fa-smoking"></i>
					</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_smoke_0" name="seat_smoke" value="-1"><label for="seat_smoke_0">指定なし</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_smoke_1" name="seat_smoke" value="0"><label for="seat_smoke_1">禁煙席</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_smoke_2" name="seat_smoke" value="1"><label for="seat_smoke_2">喫煙席</label>
				</div>
				<div class="col-md-auto"></div>
			</div>

			<div class="row my-2">
				<div class="col-md-2 text-md-right">
					<label>
						備考
						<i class="far fa-clipboard"></i>
					</label>
				</div>
				<div class="col-md-10">
					<textarea class="w-75" id="reserve_notes" name="reserve_notes" rows="2"></textarea>
				</div>
				<div class="col-md-auto"></div>
			</div>

			<div class="row justify-content-center">
				<button type="button" class="btn btn-outline-primary btn-block" id="search_button" name="search_button" data-action="reserve_add.php" data-cmd="search">
					空席の確認
				</button>
			</div>
<?php
	try {
		if ($_POST['cmd']=="search") {
			$pdo = connectdb();
			$stmt = select_m_seat($pdo, $_POST['seat_type'], $_POST['seat_smoke']);
?>
			<div id="seat_check" class="row justify-content-center my-2">
				<div class="col-md-8 table-responsive">

					<table class="table">
						<thead>
							<tr class="text-nowrap">
								<th>
								</th>
								<th>
									No
								</th>
								<th>
									席名
								</th>
								<th>
									席タイプ
								</th>
								<th>
									人数
								</th>
								<th>
									喫煙
								</th>
							</tr>
						</thead>
						<tbody>
<?php $no=1; while ($row = $stmt->fetch()) { ?>
							<tr class="text-nowrap">
								<td>
									<input type="checkbox" id="seat[]" name="seat[]" value="<?php echo htmlspecialchars($row['seat_id']) ?>">
								</td>
								<td><?php echo $no++ ?></td>
								<td><?php echo htmlspecialchars($row['seat_name']) ?></td>
								<td><?php echo htmlspecialchars(get_seat_name($row['seat_type'])) ?></td>
								<td><?php echo htmlspecialchars($row['seat_quantity']) ?></td>
								<td><?php echo htmlspecialchars(get_smoke_name($row['smoking_flg'])) ?></td>
							</tr>
<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row justify-content-center">
				<button type="button" class="btn btn-outline-primary btn-block" id="reserve_button" name="reserve_button" data-action="update.php" data-cmd="insert">
					予約する
				</button>
			</div>
<?php
		}
?>
			<div class="row invisible">
				<input type="hidden" id="cmd" name="cmd" value="<?php echo htmlspecialchars($_POST['cmd']) ?>"/>
				<input type="hidden" id="hdn_phone_no" name="hdn_phone_no" value="<?php echo htmlspecialchars($_POST['phone_no']) ?>"/>
				<input type="hidden" id="hdn_client_name" name="hdn_client_name" value="<?php echo htmlspecialchars($_POST['client_name']) ?>"/>
				<input type="hidden" id="hdn_reserve_date" name="hdn_reserve_date" value="<?php echo htmlspecialchars($_POST['reserve_date']) ?>"/>
				<input type="hidden" id="hdn_reserve_time_from" name="hdn_reserve_time_from" value="<?php echo htmlspecialchars($_POST['reserve_time_from']) ?>"/>
				<input type="hidden" id="hdn_reserve_time_to" name="hdn_reserve_time_to" value="<?php echo htmlspecialchars($_POST['reserve_time_to']) ?>"/>
				<input type="hidden" id="hdn_reserve_quantity" name="hdn_reserve_quantity" value="<?php echo htmlspecialchars($_POST['reserve_quantity']) ?>"/>
				<input type="hidden" id="hdn_seat_type" name="hdn_seat_type" value="<?php echo htmlspecialchars($_POST['seat_type']) ?>"/>
				<input type="hidden" id="hdn_seat_smoke" name="hdn_seat_smoke" value="<?php echo htmlspecialchars($_POST['seat_smoke']) ?>"/>
				<input type="hidden" id="hdn_reserve_notes" name="hdn_reserve_notes" value="<?php echo htmlspecialchars($_POST['reserve_notes']) ?>"/>
			</div>

<?php
	} catch (PDOException $e) {
		header('Content-Type: text/plain; charset=UTF-8', true, 500);
		exit($e->getMessage());
	} finally {
        //TODO コネクションの解放不要？
		$pdo = null;
		$stmt = null;
	}
?>

		</form>
	</div>

		<style>
		</style>

		<script src="./common.js"></script>
		<script>
			$(function () {
				//TODO 日時項目の初期値（現在日時を設定）
				restore_value("phone_no", "");
				restore_value("client_name", "");
				restore_value("reserve_date", "");
				restore_value("reserve_time_from", "17:00");
				restore_value("reserve_time_to", "17:00");
				restore_value("reserve_quantity", "0");
				restore_radio("seat_type", "none");
				restore_radio("seat_smoke", "-1");
				restore_value("reserve_notes", "");

				$(".datepicker").datepicker({
					dateFormat: "yy-mm-dd"
				});

				$("#search_button").click(function() {
					let frm = $(this).parents('form');
					$("#cmd").val($(this).data('cmd'));
					frm.attr('action', $(this).data('action'));
					frm.submit();
				});

				$("#reserve_button").click(function() {
					$(":input[type=checkbox]")[0].setCustomValidity("");

					let frm = $(this).parents('form');
					if (!frm.get(0).checkValidity()) {
						frm.get(0).reportValidity();
						return;
					}

					if ($("#seat_check :checked").length <= 0) {
						$(":input[type=checkbox]")[0].setCustomValidity("席を選択してください。");
						frm.get(0).reportValidity();
						return;
					}

					$("#cmd").val($(this).data('cmd'));
					frm.attr('action', $(this).data('action'));
					frm.submit();
				});

				// function check_input() {
				// 	if ($("#cmd").val() == '') return;

				// 	let is_disabled = true;
				// 	if (
				// 		$("#phone_no").val() != ''
				// 		&& $("#client_name").val() != ''
				// 		&& $("#reserve_date").val() != ''
				// 		&& $("#reserve_time_from").val() != ''
				// 		&& $("#reserve_time_to").val() != ''
				// 		&& $("#reserve_quantity").val() != ''
				// 		&& $("#seat_type").val() != ''
				// 		&& $("#seat_smoke").val() != ''
				// 		&& $("#seat_check :checked").length > 0
				// 	) {
				// 		is_disabled = false;
				// 	} else {
				// 		is_disabled = true;
				// 	}
				// 	$(":button[name=reserve_button]").prop("disabled", is_disabled);
				// }

				// $(":input").change(check_input);
				// check_input();

			});
		</script>

		<pre><?php //print_r($_POST); ?></pre>

	</body>

</html>

<?php
	//TODO 暫定 クライアント側のtimepickerにおきかえ
	function output_time() {
		for($h=17;$h<24;$h++) {
			for($m=0;$m<60;$m+=30) {
				printf("<option value=\"%02d:%02d\">%02d時%02d分</option>\n", $h, $m, $h, $m);
			}
		}
	}
?>
