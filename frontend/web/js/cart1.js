/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/

$(function(){
    //总计金额
    var total = 0;
    $(".col5 span").each(function(){
        total += parseFloat($(this).text());
    });

    $("#total").text(total.toFixed(2));

    //删除
	$(".col6 a").click(function () {
		console.log(111);
		var tr=$(this).parent().parent()
        var id=tr.attr('value-id');
        $.getJSON('/goods/del-cart',{id:id},function (data) {
        	if(data.status){
        		tr.remove();
        		window.location.href='/goods/cart-list'
			}

        })

    })
	//减少
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		if (parseInt($(amount).val()) <= 1){
			alert("商品数量最少为1");
		} else{
			$(amount).val(parseInt($(amount).val()) - 1);
		}
		//修改
		var num=$(this).next().val();
		var id=$(this).parent().parent().attr('value-id');
		//ajax请求
		$.getJSON('/goods/update-cart',{id:id,amount:num},function (data) {
			
        })
		console.log(num,id);
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
	});

	//增加
	$(".add_num").click(function(){
		var amount = $(this).parent().find(".amount");
		$(amount).val(parseInt($(amount).val()) + 1);
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

        //修改
        var num=$(this).prev().val();
        var id=$(this).parent().parent().attr('value-id');
        //ajax请求
        $.getJSON('/goods/update-cart',{id:id,amount:num},function (data) {

        })

		$("#total").text(total.toFixed(2));
	});

	//直接输入
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(this).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));

	});
});