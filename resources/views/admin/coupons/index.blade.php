@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">

	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">优惠券管理</a></li>
		<li class="active">优惠券列表</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
			<a href="/admin/goods/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加优惠券</a>

			<p class="pull-right tots" >共有 10 条数据</p>
			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="" class="form-control" placeholder="请输入你要搜索的内容" id="">
				</div>

				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th><input type="checkbox" name="" id=""></th>
			<th>ID</th>
			<th>价值</th>
			<th>start_time</th>
			<th>end_time</th>
			<th>操作</th>

			@foreach($coupon as $value)
				<tr>
					<td><input type="checkbox" name="" id=""></td>
					<td>{{$value->id}}</td>
					<td>{{$value->money}}</td>
					<td>{{$value->start_time}}</td>
					<td>{{$value->end_time}}</td>
					<td><a href="">修改</a> <a href="">删除</a></td>
				</tr>
			@endforeach



		</table>
		<!-- 分页效果 -->
		<div class="panel-footer">
			<nav style="text-align:center;">
				{{$coupon->links()}}
			</nav>

		</div>
	</div>
</div>
<script>

	// 删除数据

	function del(id){

		if (confirm("您确认要删除？")) {
			// 发送post请求

			$.post("/coupon/delete/"+id,{'_token':"{{csrf_token()}}",'_method':'delete'},function(data){

				if (data==1) {
					window.location.reload();
				};

			})
		};

	}
</script>
@endsection
