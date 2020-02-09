$(document).ready(function(){
	var comments = $("#comments tbody");
	// 获取内容
	refresh();

	// 展出评论
	$("#add").on("click",function(e){
		// var user = $("#usr-name").val();
		// var txt = $("#usr-message").val();
		e.preventDefault();
		if ($("#usr-name").val()===""||$("#usr-message").val()==="") {
			if ($("#usr-name").val() ==="") {
				alert("请输入您的昵称");
			}else if($("#usr-message").val()===""){
				alert("请输入您的留言内容");
			}
		}else{
			var jsonData = {
				user:$("#usr-name").val(),
				txt:$("#usr-message").val()
			};
			$.ajax({
				url:"../server/comment.php",
				type:"POST",
				data:jsonData,
				datatype:"json",
				success:function(res){
					console.log(res);
					if (res.code == 1) {
						// var str = "<p><strong>昵称:" + res.user + "</strong>" + res.txt + "<span>刚刚</span><p>";
						// comments.append(str);
						$("#message").show().html("发表成功").fadeOut(3000);
						$("#usr-name").val("");
						$("#usr-message").val("");
						refresh();
					}else{
						$("#message").show().html(res.message).fadeOut(3000);
					}
				}
			});
		}
	});

	// 留言刷新
	function refresh(){
	comments.empty();
	$.getJSON("../server/data.php",function(json){
		$.each(json,function(index,array){
			// var text = "<p><strong>昵称:" + array["user"] + "</strong>" + array["comment"] + "<span>" + array["addtime"] + "</span></p>";
			// comments.append(text);
			var user = $("<td>").html(array["user"]);
			var comment = $("<td>").html(array["comment"]);
			var addTime = $("<td>").html(array["addtime"]);
			var tRow = $("<tr>");
			tRow.append(user,comment,addTime);
			comments.append(tRow);
		});	
	});
}

	//回到顶部按钮
	var clientHeight = $(window).height();
	var scrollTop = $(window).scrollTop();
	if (scrollTop >= clientHeight/2) {
		$(".back-top").show(500);
	}else{
		$(".back-top").hide(500);
	}
});

