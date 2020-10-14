/*$(document).ready(function(){
	 $.each($("input, textarea, select"), function(n,element){
		if($(this).attr('wajib')=="yes"){
			$(this).addClass('required');
			
		}
	});
});*/
var applicationName = "CFS CENTER";
function login(){
	var a=0;
	$('#form-login .form-input' ).each(function(n,element){
		if ($(element).val()==''){  
			a = a+1;
			$("#"+element.id).css("border","1px solid red");
		}else{
			$("#"+element.id).css("border","");
		}  
	});
	if(a>0){
		if($("#username").val()==""){
			swalert('error','Username');
			$("#username").focus();
		}
		else if($("#password").val()==""){
			swalert('error','Password');
			$("#password").focus();
		}
	}
	else{
		ExecFormLogin('#form-login');
	}
	return false;
}

function swalert(type,message,time){
	if(time!=undefined) time = time;
	else time = 2000;
	if(type=="success"){
		swal({title:applicationName,
			  text:message,
			  timer:time,
			  type:'success',
			  showConfirmButton: false,
			  html: true
		});
	}else if(type=="error"){
		swal({title:applicationName,
			  text:message,
			  timer:time,
			  type:'error',
			  showConfirmButton: false,
			  html: true
		});	
	}else if(type=="html"){
		swal({
		  title:applicationName,
		  text:message,
		  html: true
		})
	}
}

function notify_(type,msg){
	noty({
		theme: 'app-noty',
		text: msg,
		type: type,
		timeout: 10000,
		layout: 'bottom',
		closeWith: ['button', 'click'],
		animation: {
			open: 'in',
			close: 'out'
		},
	});
}

function notify(type,message){
	if(type=="confirm"){
		var noty_id = noty({
			layout : 'top',
			text: message,
			modal : true,
			buttons: [
				{type: 'btn btn-success', text: 'Ok', click: function($noty) {
					$noty.close();
					noty({force: true, text: 'You clicked "Ok" button', type: 'success'});
				  }
				},
				{type: 'button btn btn-warning', text: 'Cancel', click: function($noty) {
					$noty.close();
					noty({force: true, text: 'You clicked "Cancel" button', type: 'error'});
				  }
				}
				],
			 type : 'success', 
		});
	}else{
		var noty_id = noty({
			layout : 'bottom',
			text: message,
			modal : true,
			timeout: 500,
			//timeout: 3000, -- miliseconds
			type:type,
		});
	}
}

function ExecFormLogin(formId){
	$.ajax({
		type: 'POST',
		url: $(formId).attr('action') + '/ajax',
		data: $(formId).serialize(),
		dataType: 'json',
		success: function(data){
			if(typeof(data) != 'undefined'){
				var arrayDataTemp = data.returnData.split("|");
				if(arrayDataTemp[0]>0){
					swalert('success',arrayDataTemp[1]);
					setTimeout(function(){window.location.href=arrayDataTemp[2]}, 2000);
				}else{
					swalert('error',arrayDataTemp[1]);
				}
			}
		}
	});			
}

function validasi(form){
	var notvalid = 0;
	var notnumber = 0;
	var notnum = 0;
	var notemail = 0;
	var regEmail= new RegExp(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i); 
	var regNumber =/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
	var regNum = new RegExp(/^\d+$/);
		$.each($('#'+form+" input, #"+form+" textarea, #"+form+" select"), function(n,element){
			if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
				$(this).addClass('wajib');
				if($(element).val()==""){
					$("#"+element.id).css("border","1px solid red");
				}else{
					$("#"+element.id).css("border","");
				}
				notvalid++;
			}
			if($(this).attr('number')=="yes" && (!regNum.test($(this).val()) || $(this).val()==null)){
				$(this).addClass('number');
				if($(element).val()=="" || (!regNum.test($(this).val()))){
					$("#"+element.id).css("border","1px solid red");
				}else{
					$("#"+element.id).css("border","");
				}
				notnum++;
			}
			if($(this).attr('email')=="yes" && (!regEmail.test($(this).val()) || $(this).val()==null)){
				$(this).addClass('email');
				if($(element).val()=="" || (!regEmail.test($(this).val()))){
					$("#"+element.id).css("border","1px solid red");
				}else{
					$("#"+element.id).css("border","");
				}
				notemail++;
			}
			if($(this).attr('format')=="number" && (!regNumber.test($(this).val()) && $(this).val()!="")){
				$(this).addClass('format');
				notnumber++;
			}
		});
	if(notvalid>0 || notnumber >0 || notnum >0 || notemail >0){
		var errorString = "";
		if(notvalid > 0){
		 	errorString += 'Terdapat data yang harus diisi <br>';
		}
		if(notnum > 0){
		 	errorString += 'Terdapat angka yang harus diisi <br>';
		}
		if(notemail > 0){
		 	errorString += 'Terdapat email yang harus diisi <br>';
		}
		if(notnumber >0){
			errorString += 'There are ' + notvalid + ' data is required number';
		}
		swalert('error',errorString);
		return false;
	}else{
		return true;	
	}		
	return false;
}

function validasi_duplicate(field,divid){
	if(divid==""||typeof(divid)=="undefined"){
		var divid = "msg_";	
	}else{		
		var divid = divid;		
	}
	var notduplicate = 0;
	$.each($("input:hidden"), function(n,element){
		if($(this).attr('duplicate')=="no" && $('#'+field).val()==$(this).val()){
			$(this).addClass('duplicate');
				notduplicate++;
		}
	});
	if(notduplicate>0){
		var errorString = "Notifikasi!";
		errorString += '<br>Terdapat data yang sama';
		$("."+divid).css('color', 'red');
		noty({text:errorString, type: 'error'});
		return false;
	}else{
		return true;	
	}		
	return false;
}

function save_post(form,id){
	if(validasi(form)){
		if(validasi(form)){
		swal({title:'Confirm',
		  text:'Apakah ingin proses data ?',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		 },function(r){
			 if(r){
				$.ajax({
				type: 'POST',
				url: $('[name="'+form+'"]').attr('action'),
				data: $('[name="'+form+'"]').serialize(),
				beforeSend: function(){Loading(true)},
				complete:function(){Loading(false)},
				success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							setTimeout(function(){location.href = arrdata[3];}, 1500);
							return false;
						}else{
							notify('error',arrdata[2]);
						}
					}
				}
				});
			 }else{
				return false
			 }
		});
	}
	}
}

function save_popup(form,div){
	if(validasi(form)){
		swal({title:'Confirm',
		  text:'Apakah ingin process data ?',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		 },function(r){
			 if(r){
				$.ajax({
				type: 'POST',
				url: $('[name="'+form+'"]').attr('action'),
				data: $('[name="'+form+'"]').serialize(),
				beforeSend: function(){Loading(true)},
				complete: function(){Loading(false)},
				success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							if(div==undefined)
								setTimeout(function(){location.href = arrdata[3];}, 1500);
							else
								$('#'+div).load(arrdata[3]);
							jpopup_close();
						}else{
							notify('error',arrdata[2]);	
						}
					}
				}
				});
			 }else{
				return false
			 }
		});
	}
}

function print_popup(form,url,id){
	if(validasi(form)){
		swal({title:'Confirm',
		  text:'Apakah ingin process data ?',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		 },function(r){
			 if(r){
				var width = 800;
				var height = 500;
				var winl = (screen.width - width) / 2;
				var wint = (screen.height - height) / 2;
				popupWindow = window.open(url + '/' + id, 'OpenWindows', 'left='+winl+',top='+wint+',width='+width+', height='+height+',scrollbars=yes,resizable=yes,statusbar=yes');
			 }else{
				return false
			 }
		});
	}
}

function send_popup(form,div,url,id){
	if(validasi(form)){
		swal({title:'Confirm',
		  text:'Apakah ingin process data ?',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		 },function(r){
			 if(r){
				$.ajax({
					type: 'POST',
					url: url,
					data:{id : id},
					beforeSend: function(){Loading(true)},
					complete: function(){Loading(false)},
					success: function(data){
						if(data.search("MSG")>=0){
							arrdata = data.split('#');
							if(arrdata[1]=="OK"){
								notify('success',arrdata[2]);
								if(div==undefined)
									setTimeout(function(){location.href = arrdata[3];}, 1500);
								else
									$('#'+div).load(arrdata[3]);
								jpopup_close();
							}else{
								notify('error',arrdata[2]);	
							}
						}
					}
				});
			 }else{
				return false
			 }
		});
	}
}

function process_popup_url(form,url,id,gd){
	if(validasi(form)){
		swal({title:'Confirm',
		  text:'<style>.notbold{font-weight:normal}​</style><span class="notbold">Order yang Anda input akan dikirimkan ke </span><strong>'+gd+'</strong><span class="notbold">.\n Silahkan masuk ke menu tagihan untuk proses selanjutnya ?</span>',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		  html: true
		 },function(r){
			 if(r){
				$.ajax({
				type: 'POST',
				url: $('[name="'+form+'"]').attr('action'),
				data: $('[name="'+form+'"]').serialize(),
				beforeSend: function(){Loading(true)},
				complete: function(){Loading(false)},
				success: function(data){
					jpopup_close();
					popup_search(url+'/'+id,'id='+id,80,600);	
				}
				});
			 }else{
				return false
			 }
		});
	}
}

function process_popup(form,div,gd){
	if(validasi(form)){
		swal({title:'Confirm',
		  text:'<style>.notbold{font-weight:normal}​</style><span class="notbold">Order yang Anda input akan dikirimkan ke </span><strong>'+gd+'</strong><span class="notbold">.\n Silahkan masuk ke menu tagihan untuk proses selanjutnya ?</span>',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		  html: true
		 },function(r){
			 if(r){
				$.ajax({
				type: 'POST',
				url: $('[name="'+form+'"]').attr('action'),
				data: $('[name="'+form+'"]').serialize(),
				beforeSend: function(){Loading(true)},
				complete: function(){Loading(false)},
				success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							if(div==undefined)
								setTimeout(function(){location.href = arrdata[3];}, 1500);
							else
								$('#'+div).load(arrdata[3]);
							jpopup_close();
						}else{
							notify('error',arrdata[2]);	
						}
					}
				}
				});
			 }else{
				return false
			 }
		});
	}
}

function save_popup2(form,div,div2){
	if(validasi(form)){
		swal({title:'Confirm',
		  text:'Apakah ingin process data ?',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		 },function(r){
			 if(r){
				$.ajax({
				type: 'POST',
				url: $('[name="'+form+'"]').attr('action'),
				data: $('[name="'+form+'"]').serialize(),
				beforeSend: function(){Loading(true)},
				complete: function(){Loading(false)},
				success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							if(div==undefined){
								setTimeout(function(){location.href = arrdata[2];}, 1500);
							}else{
								$('#'+div).load(arrdata[3]);
								$('#'+div2).load(arrdata[4]);
							}
							jpopup_closetwo();
						}else{
							notify('error',arrdata[2]);	
						}
					}
				}
				});
			 }else{
				return false
			 }
		});
	}
}

function save_data(form,id,param){
	if(validasi(form)){
		jConfirm('Do you want process this data ? ', applicationName, 
		function(r){if(r==true){
			$.ajax({
			type: 'POST',
			url: $('[name="'+form+'"]').attr('action'),
			data: $('[name="'+form+'"]').serialize(),
			beforeSend: function(){/*Loading(true);*/},
			success: function(data){
					Loading(false);
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							if(id!="") $('#'+id).val(arrdata[3]);
							if(param!="") $('.'+param).css('display','');
						}else{
							notify('error',arrdata[2]);	
						}
					}
				}
			});
		}else{return false;}});	
	}
}

function save_ajax(form){
	if(validasi(form)){
		swal({title:'Confirm',
		  text:'Apakah ingin process data ?',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		 },function(r){
			 if(r){
				var arrform = new FormData(document.getElementById(form));
				$.ajax({
				type: 'POST',
				url: site_url+'/'+$('[name="'+form+'"]').attr('action'),
				data: arrform,
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function(){Loading(true)},
				success: function(data){
						Loading(false);
						if(data.search("MSG")>=0){
							arrdata = data.split('#');
							if(arrdata[1]=="OK"){
								notify('success',arrdata[2]);
								setTimeout(function(){location.href = arrdata[3];}, 1500);
								return false;
							}else{
								notify('error',arrdata[2]);	
								return false;
							}
						}
					}
				});
		}else{
				return false
			 }
		});
	}
}

function save_multiple_post(form){
	var formserial = "";
	var arrform = form.split('|');
	for(var f=0; f<arrform.length; f++){
		formserial += '[name="'+arrform[f]+'"],';
	}
	var form = formserial.slice(0,-1);
	if(validasi(arrform[0]) && validasi(arrform[1])){
		swal({title:'Confirm',
		  text:'Apakah ingin prosess data ini ?',
		  type:'info',
		  showCancelButton:true,
		  closeOnConfirm:true,
		  showLoaderOnConfirm:true,
		 },function(r){
			 if(r){
				$.ajax({
				type: 'POST',
				url: $('[name="'+arrform[0]+'"]').attr('action'),
				data: $(form).serialize(),
				beforeSend: function(){Loading(true)},
				complete:function(){Loading(false)},
				success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							setTimeout(function(){location.href = arrdata[3];}, 1500);
							return false;
						}else{
							notify('error',arrdata[2]);
						}
					}
				}
				});
			 }else{
				return false
			 }
		});
	}
}

function save_popup_ajax(form,div) {
    if(validasi(form)){
        var arrform = new FormData(document.getElementById(form));
		jConfirm('Do you want process this data ? ', applicationName, 
		function(r){if(r==true){
			$.ajax({
			type: 'POST',
			url: $('[name="'+form+'"]').attr('action'),
			data: arrform,
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function(){Loading(true)},
			complete: function(){Loading(false)},
			success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							$('#'+div).load(arrdata[3]);
							jpopup_close();
						}else{
							notify('error',arrdata[2]);	
						}
					}
				}
			});
		}else{return false;}});	
	}
}    


function cancel(formid){
	document.getElementById(formid).reset();
	return false;
};

function Loading_Table(boolean){
	if(boolean){
		$('#Loading').show();
	}
	else{
		$('#Loading').hide();
	}	
}

function save_dialog(formid,msg){
	if(validasi(msg)){		
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="OK"){
						$("."+msg).css('color', 'green');
						$("."+msg).html(arrdata[2]);						
						$("#divtblmohon").load(arrdata[3]);
						closedialog('dialog-tbl');
					}else{
						$("."+msg).css('color', 'red');
						$("."+msg).html(arrdata[2]);
					}
				}else{
					$("."+msg).css('color', 'red');
					$("."+msg).html('Proses Gagal.');
				}
			}
		});	
	}return false;	
}

function list_tbl(id,divid){
	jloadings();
	var dok=$("#"+id).val();
	page=$("#"+id).attr("url")+"/"+dok;
	$('#'+divid).load(page,function(){
		Clearjloadings();	
		$("#"+id).val(0);
	});
};

function multiReplace(str, match, repl) {
    do {
        str = str.replace(match, repl);
    } while(str.indexOf(match) !== -1);
    return str;
}

function FormatHS(varnohs){
	if (varnohs!=""){
		varnohs = multiReplace(varnohs,'.','');
		var varresult = '';
		var varresult = varnohs.substr(0,4)+"."+varnohs.substr(4,2)+"."+varnohs.substr(6,2)+"."+varnohs.substr(8,2);
		return varresult;
	}
}

function getDataCombo(form,val,get){
	var getVal=$("#"+form+" #"+val).val();
	$("#"+form+" #"+get).val(getVal);
}

function limitChars(textid, limit, infodiv){
	var text = $('#'+textid).val(); 
	var textlength = text.length;
	if(textlength > limit)
	{
		$('#' + infodiv).html('<font color="red">Tidak bisa lebih dari '+limit+' karakter!</font>');
		$('#'+textid).val(text.substr(0,limit));
		return false;
	}
	else
	{
		$('#' + infodiv).html('<font color="green">'+(limit - textlength) +' karakter yang tersisa.</font>');
		return true;
	}
}

function intInput(event, keyRE) {
	if ( String.fromCharCode(((navigator.appVersion.indexOf('MSIE') != (-1)) ? event.keyCode : event.charCode)).search(keyRE) != (-1)
		|| ( navigator.appVersion.indexOf('MSIE') == (-1)
			&& ( event.keyCode.toString().search(/^(8|9|13|45|46|35|36|37|39)$/) != (-1) 
				|| event.ctrlKey || event.metaKey ) ) ) {
		return true;
	} else {
		return false;
	}
}

function autocomplete(divid,url,source){
	$("#"+divid).autocomplete({ 
	minLength:1,
	delay:0,
	autofocus:true,
	source: function (request, response){
		$.ajax({
		  type: "POST",
		  url: site_url + url,
		  data: request,
		  success: response,
		  dataType: 'json'
		});
	  },
	 select:source
	});
}

function strpos(haystack, needle, offset){
    var i = (haystack + '').indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}

function check(id,input)
{
	var check = new Array();
	$.each($("input[id='"+id+"']:checked"),function(){
	  check.push($(this).val());
	});	
	$('#'+input).val(check);
}

function send_id(form,id,met){
	if(validasi(form)){
		var getid = $('[name="'+id+'"]').val();
		if(getid==""){
			notify('error','There are data is required');
			return false;
		}
		jConfirm('Do you want process this data ? ', applicationName,
		function(r){if(r==true){
			$.ajax({
			type: 'POST',
			url: $('#'+met).attr('action'),
			data: 'sendid='+getid+'&'+$('[name="'+form+'"]').serialize(),
			beforeSend: function(){Loading(true)},
			success: function(data){
					Loading(false);
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="OK"){
							notify('success',arrdata[2]);
							setTimeout(function(){location.href = arrdata[3];}, 1500);
							return false;
						}else{
							notify('error',arrdata[2]);
						}
					}
				}
			});
		}else{return false;}});
	}
}

function send_multiple_id(form,id,met){
	var formserial = "";
	var arrform = form.split('|');
	for(var f=0; f<arrform.length; f++){
		formserial += '[name="'+arrform[f]+'"],';
	}
	var form = formserial.slice(0,-1);
	if(validasi(arrform[0])){
		var getid = $('[name="'+id+'"]').val();
		if(getid==""){
			notify('error','There are data is required');
			return false;
		}
		if(validasi(arrform[1])){
			jConfirm('Do you want process this data ? ', applicationName,
			function(r){if(r==true){
				$.ajax({
				type: 'POST',
				url: $('#'+met).attr('action'),
				data: 'sendid='+getid+'&'+$(form).serialize(),
				beforeSend: function(){Loading(true)},
				success: function(data){
						Loading(false);
						if(data.search("MSG")>=0){
							arrdata = data.split('#');
							if(arrdata[1]=="OK"){
								notify('success',arrdata[2]);
								setTimeout(function(){location.href = arrdata[3];}, 1500);
								return false;
							}else{
								notify('error',arrdata[2]);
							}
						}
					}
				});
			}else{return false;}});
		}
	}
}

function date_y(className){
	$("."+className).datetimepicker({
        format: "yyyy",
		autoclose: true,
		startView: "4", 
		viewMode:'years',
		minView: '4'
	});
}

function date_m(className){
	$("."+className).datetimepicker({
        //language: "id",
        format: "MM yyyy",
		autoclose: true,
		startView: "3", 
		viewMode:'years',
		minView: '3'
	});
}

function date(className){
	$("."+className).datetimepicker({
		format: "dd-mm-yyyy",
		todayBtn: true,
		todayHighlight: true,
		autoclose: true,
		minView: '2'
	});
}

function past_date(className){
	$("."+className).datetimepicker({
		format: "dd-mm-yyyy",
		startDate: "+0d",
		todayBtn: true,
		todayHighlight: true,
		autoclose: true,
		minView: '2'
	});
}

function datetime(className){
	$('.'+className).datetimepicker({
		format: "dd-mm-yyyy h:i:s",
		todayBtn: true,
		todayHighlight: true
	});
}

function datetimelimit(className){
	$('.'+className).datetimepicker({			
		format: "dd-mm-yyyy h:i:s",
		todayBtn: true,
		todayHighlight: true,
		startDate: "-5d",
		endDate: "+0d"
	
		
	});
}


function ajax_lokasi(id,div,act){
	var arrdiv = div.split('|');
	var arract = act.split('/');
	var url = site_url+'/'+act+'/'+Math.random();
	$.post(url,{id:id,name:arrdiv},
		function(data){
			if(arract[2]=='kabupaten'){
				$('#DIV_'+arrdiv[0]).html(data);
				for(var a=1; a<arrdiv.length; a++){
					$('#DIV_'+arrdiv[a]).html('<select class="form-control" name="DATA['+arrdiv[a]+']" id="'+arrdiv[a]+'" wajib="yes" style="width:100%"><option></option></select>');
				}
			}else if(arract[2]=='kecamatan'){
				$('#DIV_'+arrdiv[1]).html(data);
				for(var a=2; a<arrdiv.length; a++){
					$('#DIV_'+arrdiv[a]).html('<select class="form-control" name="DATA['+arrdiv[a]+']" id="'+arrdiv[a]+'" wajib="yes"><option></option></select>');
				}
			}else if(arract[2]=='kelurahan'){
				$('#DIV_'+arrdiv[2]).html(data);
			}
	}, "html");
}

function on_detail(id,div,act){
	var url = site_url+'/'+act+'/'+Math.random();
	$.post(url,{id:id},
		function(data){
			$('#'+div).html(data);
	}, "html");
}

function on_same(class_id,val){
	$('.'+class_id).val(val);
}