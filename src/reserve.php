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
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
	 crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
	 crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
	 crossorigin="anonymous"></script>
	<title>予約管理システム/予約一覧</title>
</head>

<body>
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
<?php
	try {
		$pdo = connectdb();
		$stmt = select_reserve_info($pdo);
?>
		<form method="POST" id="reserve_form">

		<div class="row table-responsive my-2">
			<table class="table">
				<thead>
					<tr class="text-nowrap">
						<th>
							No
						</th>
						<th>
							予約番号
							&sharp;
						</th>
						<th>
							お名前
							<i class="fas fa-user"></i>
						</th>
						<th>
							電話番号
							<i class="fas fa-phone"></i>
						</th>
						<th>
							予約日時
							<i class="far fa-calendar-alt"></i>
						</th>
						<th>
							人数
							<i class="fas fa-users"></i>
						</th>
						<th>
							席
							<i class="fas fa-chair"></i>
						</th>
						<th>
							状態
							<i class="fas fa-info-circle"></i>
						</th>
						<th>
						</th>
						<th>
						</th>
					</tr>
				</thead>
				<tbody>
<?php $no=1; while ($row = $stmt->fetch()) { ?>
					<tr class="text-nowrap">
						<td><?php echo $no++ ?></td>
						<td><?php echo htmlspecialchars($row['reserve_id']) ?></td>
						<td><?php echo htmlspecialchars($row['customer_name']) ?></td>
						<td><?php echo htmlspecialchars($row['customer_tel']) ?></td>
						<td><?php echo format_reserve_date(htmlspecialchars($row['reserve_date_from']), htmlspecialchars($row['reserve_date_to']))?></td>
						<td class="text-right"><?php echo htmlspecialchars($row['reserve_quantity']) ?></td>
						<td><?php echo htmlspecialchars($row['seat_name']) ?></td>
						<td>来店待ち</td>
						<td>
							<button type="button" class="btn btn-outline-primary btn-sm">
								変更
							</button>
						</td>
						<td>
							<button type="button" class="btn btn-outline-primary btn-sm">
								取消
							</button>
						</td>
					</tr>
<?php } ?>
				</tbody>
			</table>
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
		<div class="row justify-content-center my-2">
			<button type="button" class="btn btn-outline-primary btn-block" id="reserve_button" name="reserve_button" data-action="reserve_add.php" data-cmd="">
				予約登録
				<i class="fas fa-plus fa-5"></i>
			</button>
		</div>

		<input type="hidden" id="cmd" name="cmd" value=""/>
		</form>

	</div>

	<style>
	</style>

	<script>
		$(function () {
			$(":button").click(function() {
				if ($(this).data('action') != '') {
					$(this).parents('form').attr('action', $(this).data('action'));
					$("#cmd").val($(this).data('cmd'));
					$(this).parents('form').submit();
				}
			});
		});
	</script>

</body>

</html>