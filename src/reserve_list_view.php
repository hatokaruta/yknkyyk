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
					<a class="nav-link active" href="reserve_list.php">予約一覧</a>
				</li>
			</ul>
		</nav>
		<form id="reserve_form">

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
<?php
	for ($model->select_list(); $row = $model->fetch_list(); ) {
?>
					<tr class="text-nowrap">
						<td>
							<?php echo $row->no ?>
						</td>
						<td>
							<?php echo htmlspecialchars($row->reserve_id) ?>
						</td>
						<td>
							<?php echo htmlspecialchars($row->customer_name) ?>
						</td>
						<td>
							<?php echo htmlspecialchars($row->customer_tel) ?>
						</td>
						<td>
							<?php echo htmlspecialchars($row->reserve_date_time)?>
						</td>
						<td class="text-right">
							<?php echo htmlspecialchars($row->reserve_quantity) ?>
						</td>
						<td>
							<?php echo htmlspecialchars($row->seat_name) ?></td>
						<td>
							来店待ち
						</td>
						<td>
							<button type="button" class="btn btn-outline-primary btn-sm" name="edit_button" data-action="reserve_detail.php" data-method="get" data-cmd="edit" data-param="<?php echo htmlspecialchars($row->reserve_id) ?>">
								変更
							</button>
						</td>
						<td>
							<button type="button" class="btn btn-outline-primary btn-sm" name="cancel_button" data-action="reserve_detail.php" data-method="get" data-cmd="cancel" data-param="<?php echo htmlspecialchars($row->reserve_id) ?>">
								取消
							</button>
						</td>
					</tr>
<?php
	}
?>
				</tbody>
			</table>
		</div>
		<div class="row justify-content-center my-2">
			<button type="button" class="btn btn-outline-primary btn-block" id="reserve_button" name="reserve_button" data-action="reserve_detail.php" data-method="post" data-cmd="reserve" data-param="">
				予約登録
				<i class="fas fa-plus fa-5"></i>
			</button>
		</div>

		<input type="hidden" id="cmd" name="cmd" value=""/>
		<input type="hidden" id="reserve_id" name="reserve_id" value=""/>
		</form>

	</div>

	<style>
	</style>

	<script src="./common.js"></script>
	<script src="./reserve_list.js"></script>

</body>

</html>