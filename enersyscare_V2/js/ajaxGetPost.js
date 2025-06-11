function post_ajax_data(url,encodedata,success){
	$.ajax({
		type:"GET",
		url:url,
		data :encodedata,
		dataType:"json",
		restful:true,
		contentType: 'application/json',
		cache:false,
		timeout:20000,
		async:true,
		beforeSend :function(data) {},
		success:function(data){success.call(this, data);},
		error:function(data){alert("Error In Connecting");}
	});
}