<?php // TODO 未着手 ?>
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
	<title>予約管理システム/予約変更</title>
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
		<form action="reserve_post.php" method="POST">

			<div class="row">
				<div class="col-md-2 text-md-right">
					<label for="phone_no">
						電話番号
						<i class="fas fa-phone"></i>
					</label>
				</div>
				<div class="col-md-10">
					<input type="text" class="w-75" id="phone_no" name="phone_no" placeholder="09012345678" value="" disabled>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2 text-md-right">
					<label for="client_name">
						お名前
						<i class="fas fa-user"></i>
					</label>
				</div>
				<div class="col-md-10">
					<input type="text" class="w-75" id="client_name" name="client_name" placeholder="お名前" value="" disabled>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 text-md-right">
					<label for="reserve_date">
						予約日
						<i class="far fa-calendar-alt"></i>
					</label>
				</div>
				<div class="col-md-10">
					<input type="text" class="w-75" id="reserve_date" name="reserve_date" placeholder="YYYY-MM-DD" value="">
					<span class="badge badge-warning">必須</span>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 text-md-right">
					<label for="reserve_time">
						予約時刻
						<i class="far fa-clock"></i>
					</label>
				</div>
				<div class="col-md-8">
					<select class="w-25" id="reserve_time" name="reserve_time">
						<option value=""></option>
						<option value="17:00">17時00分</option>
						<option value="17:30">17時30分</option>
						<option value="18:00">18時00分</option>
						<option value="18:30">18時30分</option>
						<option value="19:00">19時00分</option>
						<option value="19:30">19時30分</option>
						<option value="20:00">20時00分</option>
						<option value="20:30">20時30分</option>
						<option value="21:00">21時00分</option>
						<option value="21:30">21時30分</option>
						<option value="22:00">22時00分</option>
						<option value="22:30">22時30分</option>
					</select>
					&nbsp;～&nbsp;
					<select class="w-25" id="reserve_time" name="reserve_time">
						<option value=""></option>
						<option value="17:00">17時00分</option>
						<option value="17:30">17時30分</option>
						<option value="18:00">18時00分</option>
						<option value="18:30">18時30分</option>
						<option value="19:00">19時00分</option>
						<option value="19:30">19時30分</option>
						<option value="20:00">20時00分</option>
						<option value="20:30">20時30分</option>
						<option value="21:00">21時00分</option>
						<option value="21:30">21時30分</option>
						<option value="22:00">22時00分</option>
						<option value="22:30">22時30分</option>
					</select>
					<span class="badge badge-warning">必須</span>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 text-md-right">
					<label for="quantity">
						人数
						<i class="fas fa-users"></i>
					</label>
				</div>
				<div class="col-md-8">
					<input type="text" class="w-25" id="quantity" name="quantity" placeholder="" value="">&nbsp;人
					<span class="badge badge-warning">必須</span>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 text-md-right">
					<label>
						席タイプ
						<i class="fas fa-chair"></i>
					</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_type_0" name="seat_type" value="box"><label for="seat_type_0">指定なし</label>
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

			<div class="row">
				<div class="col-md-2 text-md-right">
					<label>
						喫煙
						<i class="fas fa-smoking"></i>
					</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_smoke_0" name="seat_smoke" value="0"><label for="seat_smoke_0">指定なし</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_smoke_1" name="seat_smoke" value="0"><label for="seat_smoke_1">禁煙席</label>
				</div>
				<div class="col-md-2">
					<input type="radio" id="seat_smoke_2" name="seat_smoke" value="1"><label for="seat_smoke_2">喫煙席</label>
				</div>
				<div class="col-md-auto"></div>
			</div>

			<div class="row">
				<div class="col-md-2 text-md-right">
					<label>
						備考
						<i class="far fa-clipboard"></i>
					</label>
				</div>
				<div class="col-md-10">
					<textarea class="w-75" id="note" name="note" rows="2"></textarea>
				</div>
				<div class="col-md-auto"></div>
			</div>

			<div class="row justify-content-center">
				<button type="button" class="btn btn-outline-primary btn-block">
					空席の確認
				</button>
			</div>

			<div class="row justify-content-center">
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
							<tr class="text-nowrap">
								<td>
									<input type="checkbox" id="seat_1" name="seat_1" value="1" checked>
								</td>
								<td>1</td>
								<td>A席</td>
								<td>テーブル席</td>
								<td>4</td>
								<td>◯</td>
							</tr>
							<tr class="text-nowrap">
								<td>
									<input type="checkbox" id="seat_2" name="seat_2" value="1">
								</td>
								<td>2</td>
								<td>B席</td>
								<td>テーブル席</td>
								<td>4</td>
								<td>◯</td>
							</tr>
							<tr class="text-nowrap">
								<td>
									<input type="checkbox" id="seat_3" name="seat_3" value="1">
								</td>
								<td>3</td>
								<td>C席</td>
								<td>ボックス席</td>
								<td>8</td>
								<td>×</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row justify-content-center">
				<button type="submit" class="btn btn-outline-primary btn-block">
					変更する
				</button>
			</div>

		</form>

		<style>
		</style>

		<script>
		</script>
</body>

</html>