function get_info_file(el,login,autors,keywords,pulpit,facultet,speciality,profile,job,section){
	$.ajax({
		type: "POST",
		url: "execute/get_info_file.php",
		dataType: "json",
		data: "name_login="+login+"&name_autors="+autors+"&name_keywords="+keywords+"&name_pulpit="+pulpit+"&name_facultet="+facultet+"&name_speciality="+speciality+"&name_profile="+profile+"&name_job="+job+"&name_section="+section,
		success: function(response){
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_login_class").html(response[0]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_autors_class").html(response[1]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_keywords_class").html(response[2]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_kafedra_class").html(response[3]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_facultet_class").html(response[4]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_speciality_class").html(response[5]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_profile_class").html(response[6]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_job_class").html(response[7]);
			$(el).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_section_class").html(response[8]);
		}
	});
}

$(document).ready(function(){
	$('input[placeholder], textarea[placeholder]').placeholder();
	$("#log_datepicker_start, #log_datepicker_end").datepicker({changeMonth:true,changeYear:true,dateFormat:'dd-mm-yy',showAnim:'clip'});

	$(".autorization_button").click(function(){
		$(".darken").show();
		$(".autorization_area").fadeIn(200);
		$(".autoriz_login").focus();
	});
	
	$(".option_button").click(function(){
		$(".darken").show();
		$(".option_area").animate({'top':'20%'},200);
	});
	
	$(".darken, .edit_area_close, .delete_question-no").click(function(){
		$(".darken").fadeOut(200);
		$(".edit_area").animate({"left":"10%","opacity":"0"},300,function(){
			$(".edit_area").hide();
		});
		$(".delete_question").hide();
		$(".autorization_area").fadeOut(200);
		$(".player_canvas").hide();
	});
	
	/* Нажали на кнопку меню "Загрузить файл" */
	$(".load_button").click(function(){
		$(".section_add_file").show();
		$(".section_search").hide();
		$(".section_stat").hide();
		$(".section_logs").hide();
	});
	/* Нажали на кнопку меню "Поиск файлов" */
	$(".search_button").click(function(){
		$(".section_search").show();
		$(".section_add_file").hide();
		$(".section_stat").hide();
		$(".section_logs").hide();
	});
	/* Нажали на кнопку меню "Статистика" */
	$(".statistics_button").click(function(){
		$(".section_stat").show();
		$(".section_add_file").hide();
		$(".section_search").hide();
		$(".section_logs").hide();
	});
	/* Нажали на кнопку меню "Логи" */
	$(".logs_button").click(function(){
		$(".section_stat").hide();
		$(".section_add_file").hide();
		$(".section_search").hide();
		$(".section_logs").show();
	});
	
	/* Нажали на любую кнопку меню */
	$(".header_element").click(function(){
		$(".header_element").css({"color":"white"});
		$(this).css({"color":"#f88"});
	});
		
	$(".add_file_real").change(function(){
		if($(this).val()!='') {
			filename_string = new String( $(this).val() );
			if(filename_string[0]!="C"){
				// для FireFox
				name_file = filename_string.substr(0,filename_string.lastIndexOf("."));
				$(".add_file_name").val( name_file );
			} else {
				// для Google Chrome
				$(".add_file_beauty").val( filename_string );
				arr_file = filename_string.split("\\");
				name_file = arr_file[2].substr(0,arr_file[2].lastIndexOf("."));
				$(".add_file_name").val( name_file );
			}
			$(".add_file_beauty").val("Файл успешно выбран!");
		}
	});
	
	$(".add_file_autors_s").change(function(){
		text = $(".add_text_autors").html();
		text_id = $(".add_file_autors_h").val();
		if( $(".add_file_autors_s").val() == ""){
			separator=" ";
		} else {
			separator=";";
		}
		$(".add_text_autors").html(text+$(".add_file_autors_s option:selected").text() + separator );
		$(".add_file_autors_h").val(text_id+$(".add_file_autors_s").val() + separator );
		
		$(".add_file_autors_s option:selected").attr("disabled","disabled");
		$(".text_autors_h").val( $(".add_text_autors").html() );
	});
	
	$(".add_file_keywords_s").change(function(){
		text_keywords = $(".add_text_keywords").html();
		text_id_keywords = $(".add_file_keywords_h").val();
		if( $(".add_file_keywords_s").val() == ""){
			separator_keywords=" ";
		} else {
			separator_keywords=";";
		}
		$(".add_text_keywords").html(text_keywords+$(".add_file_keywords_s option:selected").text() + separator_keywords );
		$(".add_file_keywords_h").val(text_id_keywords+$(".add_file_keywords_s").val() + separator_keywords );
		
		$(".add_file_keywords_s option:selected").attr("disabled","disabled");
		$(".text_keywords_h").val( $(".add_text_keywords").html() );
	});
	
	$(".clear_autors").click(function(){
		$(".add_text_autors").html("");
		_last_id = $(".add_file_autors_h").attr("id"); 
		_id_end = _last_id + ";";
		$(".add_file_autors_h").val(_id_end);
		$(".text_autors_h").val("");
		
		$('.add_file_autors_s option').each(function(){
			$(this).attr("disabled","");
		});
		$(".add_file_autors_s option[value='not_autors']").attr("disabled","disabled");
	});
	
	$(".clear_keywords").click(function(){
		$(".add_text_keywords").html("");
		_last_id_keywords = $(".add_file_keywords_h").attr("id"); 
		_id_end_keywords = _last_id_keywords + ";";
		$(".add_file_keywords_h").val(_id_end_keywords);
		$(".text_keywords_h").val("");
		
		$('.add_file_keywords_s option').each(function(){
			$(this).attr("disabled","");
		});
		$(".add_file_keywords_s option[value='not_keywords']").attr("disabled","disabled");
	});

	_validate = false; //Флаг валидного ввода автора
	
	//Маска ввода авторов: 
	//Неопределенное количество русских букв, один пробел, одна заглавная буква, одна точка, одна заглавная буква, одна точка.
	var pattern_one = /^[А-Яа-я]+\s{1}[А-Я]{1}\.{1}[А-Я]{1}\.{1}$/i;
	var pattern_two = /^[А-Яа-я]+\s{1}[А-Я]{1}\.{1}$/i;
	_last_id = $(".add_file_autors_h").val();
	$(".add_file_autors_h").val(_last_id+";");
	_last_id_keywords = $(".add_file_keywords_h").val();
	$(".add_file_keywords_h").val(_last_id_keywords+";");
	
	
	/* -------------- Нажимаем клавиши на клавиатуре в разделе "Выбор автора" ----------------- */
	$(".add_file_autors_t").keyup(function (e){
		_number_show = 0; //Количество отображаемых пунктов Select'а
		_val = $(".add_file_autors_t").val();
		var _val_lover_object = new String(_val);
		_val_lover = _val_lover_object.toLowerCase();
		
		if(pattern_one.test(_val) || pattern_two.test(_val)){
			$(this).css({"background":"#5f5"});
			$(this).css({"border":"1px solid #0f0"});
			_validate = true;
		} else {
			$(this).css({"background":"#f66"});
			$(this).css({"border":"1px solid #f66"});
			_validate = false;
		}
		
		if( _val == "" ){
			$(".add_file_autors_s").hide();
			$(".add_file_autors_t").css({"background":"white"});
			$(".add_file_autors_t").css({"border":"1px solid #ccc"});
			_validate = false;
			$(".add_autors").hide();
		} else {
			$(".add_file_autors_s").show();
			
			$('.add_file_autors_s option').each(function(){
				var str = new String( $(this).html() );
				cool = str.toLowerCase();
				
				if( !cool.search(_val_lover) ){
					$(this).show();
					_number_show ++;
				} else {
					$(this).hide();
				}
			});
		
			switch(_number_show){
				case 0: _height_select_autors = 29+"px"; break;
				case 1: _height_select_autors = 29+"px"; break;
				case 2: _height_select_autors = 47+"px"; break;
				case 3: _height_select_autors = 60+"px"; break;
				default: _height_select_autors = 74+"px";
			}
			$(".add_file_autors_s").css({"height":_height_select_autors});
			if(_number_show == 0){
				$(".add_file_autors_s option[value='not_autors']").show();
			} else {
				$(".add_file_autors_s option[value='not_autors']").hide();
			}
			
			if( _validate && _number_show==0 ){
				$(".add_autors").show();
			} else {
				$(".add_autors").hide();
			}
		}
	});
	
	$(".add_file_autors_t").focus(function(){
		$(".add_file_keywords_s").hide();
		$(".add_file_keywords_t").val("");
		$(".add_keywords").hide();
	});
	
	$(".add_file_keywords_t").focus(function(){
		$(".add_file_autors_t").val("");
		$(".add_file_autors_t").css({"background":"white"});
		$(".add_file_autors_t").css({"border":"1px solid #ccc"});
		$(".add_file_autors_s").hide();
		$(".add_autors").hide();
	});
	
	$(".add_file_autors_s").mouseenter(function (){
		if( _number_show == 0 ){
			if(_validate){
				$(".add_file_autors_s option[value='not_autors']").text("Нажмите на плюс");
			} else {
				$(".add_file_autors_s option[value='not_autors']").text("Ввод некорректен");
			}
		} 
	});
	$(".add_file_autors_s").mouseleave(function (){
		if( _number_show == 0 ){
			$(".add_file_autors_s option[value='not_autors']").text("Автора в базе нет");
		}
	});
	
	/* -------------- Нажимаем клавиши на клавиатуре в разделе "Ключевое слово" ----------------- */
	$(".add_file_keywords_t").keyup(function (e){
		_number_show_keywords = 0; //Количество отображаемых пунктов Select'а
		_val_keywords = $(".add_file_keywords_t").val();
		
		var _val_lover_object_key = new String(_val_keywords);
		_val_lover_key = _val_lover_object_key.toLowerCase();

		if( _val_lover_key == "" ){
			$(".add_file_keywords_s").hide();
			$(".add_file_keywords_t").css({"background":"white"});
			$(".add_file_keywords_t").css({"border":"1px solid #ccc"});
			$(".add_keywords").hide();
		} else {
			$(".add_file_keywords_s").show();
			
			$('.add_file_keywords_s option').each(function(){
				var str_keywords = new String( $(this).html() );
				cool_keywords = str_keywords.toLowerCase();
				
				if( !cool_keywords.search(_val_lover_key) ){
					$(this).show();
					_number_show_keywords ++;
				} else {
					$(this).hide();
				}
			});
			
			if (_number_show_keywords == 0) $(".add_keywords").show();
			
			switch(_number_show_keywords){
				case 0: _height_select_key = 29+"px"; break;
				case 1: _height_select_key = 29+"px"; break;
				case 2: _height_select_key = 47+"px"; break;
				case 3: _height_select_key = 60+"px"; break;
				default: _height_select_key = 74+"px";
			}
			$(".add_file_keywords_s").css({"height":_height_select_key});
			if(_number_show_keywords == 0){
				$(".add_file_keywords_s option[value='not_keywords']").show();
			} else {
				$(".add_file_keywords_s option[value='not_keywords']").hide();
			}
		} 
	});
	
	$(".add_file_keywords_s").mouseenter(function (){
		if( _number_show_keywords == 0 ){
			$(".add_file_keywords_s option[value='not_keywords']").text("Нажмите на плюс");
		} 
	});
	$(".add_file_keywords_s").mouseleave(function (){
		if( _number_show_keywords == 0 ){
			$(".add_file_keywords_s option[value='not_keywords']").text("Слова в базе нет");
		}
	});
	
	$(".add_autors").click(function (){
		text_old = $(".add_text_autors").html();
		text_hidden = $(".add_file_autors_h").val();
		if( $(".add_file_autors_t").val() == ""){
			separator=" ";
		} else {
			separator=";";
		}
		_last_id=(_last_id*1)+1;
		$(".add_text_autors").html(text_old + $(".add_file_autors_t").val() + separator);
		$(".add_file_autors_t").val("");
		$(".add_file_autors_s").hide();
		$(".add_file_autors_t").css({"background":"white"});
		$(".add_file_autors_t").css({"border":"1px solid #ccc"});
		$(".add_file_autors_h").val( text_hidden+_last_id+separator );
		$(".add_autors").hide();
		
		var firstBig = $(".add_text_autors").html();
		firstBig = firstBig.charAt(0).toUpperCase() + firstBig.substr(1);

		$(".text_autors_h").val( firstBig );
	});
	$(".add_keywords").click(function (){
		text_old_keywords = $(".add_text_keywords").html();
		text_hidden_keywords = $(".add_file_keywords_h").val();
		if( $(".add_file_keywords_t").val() == ""){
			separator_keywords=" ";
		} else {
			separator_keywords=";";
		}

		_last_id_keywords=(_last_id_keywords*1)+1;
		$(".add_text_keywords").html(text_old_keywords + $(".add_file_keywords_t").val() + separator_keywords);
		$(".add_file_keywords_t").val("");
		$(".add_file_keywords_s").hide();
		$(".add_file_keywords_h").val( text_hidden_keywords+_last_id_keywords+separator_keywords );
		$(".add_keywords").hide();
		$(".text_keywords_h").val( $(".add_text_keywords").html() );

	});
	
	$(".add_file_facultet_s").change(function(){
		_class_name = ".kaf-"+$(this).val();
		if( $(this).val() == 0 ){
			$(".hide_show_table").hide();
		} else {
			$(".hide_show_table").show();
			$(".hide_show_table option").hide();
			$(_class_name).show();
			$('.hide_show_table select').each(function(){
				$(this).val("0");
			});
			$(".hide_show_table option[value='0']").show();

			if( $(".add_file_facultet_s").val() == 5 ){
				$(".prof").html("Должность");
				$(".profile_podgotovki").html("Категория сотрудников");
				$(".dol_kat").html("Узкая специализация");
				$(".add_file_speciality_s option[value='0']").html("Выбрать должность...");
			} else {
				$(".prof").html("Специальность / Направление подготовки");
				$(".profile_podgotovki").html("Специализация / Профиль подготовки");
				$(".dol_kat").html("Должностная категория");
				$(".add_file_speciality_s option[value='0']").html("Выбрать направление...");
			}
		}

		$(".add_file_keywords_s").hide();
		$(".add_file_keywords_t").val("");
		$(".add_keywords").hide();
		$(".add_file_keywords_t").css({"background":"white"});
		$(".add_file_keywords_t").css({"border":"1px solid #ccc"});

		//Внимание, костыль! Если в селектах доступен только один пункт, то делаем его видимым...
		if( $(this).val()==1 ){
			$(".add_file_speciality_s").val(9);
			$(".add_file_profile_s").val(7);
			$(".add_file_job_s").val(13);
		}

		if( $(this).val()==6 ){
			$(".add_file_job_s").parent("TD").parent("TR").hide();
		}

		if( $(this).val()==7 ){
			$(".add_file_speciality_s").val(16);
			$(".add_file_profile_s").val(22);
			$(".add_file_job_s").val(29);
		}
	});
	
	$("#formAddFile").validate({
		rules: {
			"add_file_kafedra_s": { min:1 },
			"add_file_facultet_s": { min:1 },
			"add_file_speciality_s": { min:1 },
			"add_file_profile_s": { min:1 },
			"add_file_job_s": { min:1 },
			"add_file_year_s": { min:1 },
			"add_file_section_s": { min:1 }
		},
		messages: {
			"add_file_kafedra_s": { min:"" },
			"add_file_facultet_s": { min:"" },
			"add_file_speciality_s": { min:"" },
			"add_file_profile_s": { min:"" },
			"add_file_job_s": { min:"" },
			"add_file_year_s": { min:"" },
			"add_file_section_s": { min:"" }
		}
	});
	$.validator.messages.required = "";
	
	$(".add_file_real").change(function (){
		if( $(this).val() != "" ){
			$(".add_file_beauty").removeClass("error");
		}
	});
	
	$("#formAddFile").submit(function(){
		bool_autors = false;
		bool_keywords = false;
		if( $(".add_text_autors").html() == "" ){
			$(".add_file_autors_t").addClass("error");
			bool_autors = false;
		} else {
			$(".add_file_autors_t").removeClass("error");
			bool_autors = true;
		}
		
		if( $(".add_text_keywords").html() == "" ){
			$(".add_file_keywords_t").addClass("error");
			bool_keywords = false;
		} else {
			$(".add_file_keywords_t").removeClass("error");
			bool_keywords = true;
		}
		
		if ( bool_keywords && bool_autors ){
			return true;
		} else {
			return false;
		}
	});
	
	//Скрипты для блока search
	$(".click-info").click(function(){
		rec_id = $(this).attr("id");
		var string_id = new String(rec_id);
		id = string_id.substr(4);
		info_id = "#info-"+id;

		if( $(info_id).is(":hidden") ){
			$(".info").hide();
			$(info_id).show();
		} else {
			$(info_id).hide();
		}
		
		login = $(info_id).children("td").children(".info_one_table").children("tbody").children("tr").children(".info_file_result").children(".user_login_class").attr("title");
		autors = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_autors_class").attr("title");
		keywords = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_keywords_class").attr("title");
		pulpit = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_kafedra_class").attr("title");
		facultet = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_facultet_class").attr("title");
		speciality = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_speciality_class").attr("title");
		profile = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_profile_class").attr("title");
		job = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_job_class").attr("title");
		if(job==0){
			$(".user_job_class").parent(".info_file_result").parent(".info_one_record").hide();
		}
		section = $(info_id).children("td").children(".info_one_table").children("tbody").children(".info_one_record").children(".info_file_result").children(".user_section_class").attr("title");
		get_info_file(info_id,login,autors,keywords,pulpit,facultet,speciality,profile,job,section);
	});
	
	$(".jpg_class").fancybox({
		openEffect  : 'fade',
		closeEffect : 'elastic'
	});
	$('.pdf_class').fancybox({
		openEffect  : 'none',
		closeEffect : 'none',
		type: "iframe",
		width: '90%',
		height: '100%',
		iframe : {
			preload: false
		}
	});
	
	$(".search_filter").click(function(){
		if( $(".filter_area").is(":hidden") ){
			$(".filter_area").show(400);
			$(".search_filter").css({"color":"#f88"});
		} else {
			$(".filter_area").hide(400);
			$(".search_filter").css({"color":"#fff"});
		}
	});
	
	$(".search_text").click(function(){
		$(".filter_area").show(400);
		$(".search_filter").css({"color":"#f88"});
	});
	
	$(".download_class").click(function(){
		id_file = $(this).attr("title");
		string_class_id = ".download_number_"+id_file;
		number_download = $(string_class_id).html()*1 + 1;
		$(string_class_id).html( number_download );
	});
	
	$(".add_file_kafedra_s").change(function(){
		$(".add_file_keywords_s").hide();
		$(".add_file_keywords_t").val("");
		$(".add_keywords").hide();
		$(".add_file_autors_s").hide();
		$(".add_file_autors_t").val("");
		$(".add_autors").hide();
		$(".add_file_autors_t").css({"background":"white"});
		$(".add_file_autors_t").css({"border":"1px solid #ccc"});
	});
	
	$(".filter_area_facultet").change(function(){
		_class_view = ".fac-"+$(this).val();

		if( $(this).val() == 5 ){
			$(".search_job").children(".filter_area_title").html("Должность");
			$(".search_profile").children(".filter_area_title").html("Категория сотрудников");
			$(".search_category").children(".filter_area_title").html("Должностная категория");
		} else {
			$(".search_job").children(".filter_area_title").html("Специальность / Направление подготовки");
			$(".search_profile").children(".filter_area_title").html("Специализация / Профиль подготовки");
			$(".search_category").children(".filter_area_title").html("Узкая специализация");
		}
		
		$(".filter_area_job").val(0);
		$(".filter_area_profile").val(0);
		$(".filter_area_category").val(0);
		
		if( $(".filter_area_facultet").val() != 0 ){
			$(".search_job").show();
			$(".search_profile").show();
			$(".search_category").show();
		} else {
			$(".search_job").hide();
			$(".search_profile").hide();
			$(".search_category").hide();
		}
		$(".filter_area_job option").hide();
		$(".filter_area_profile option").hide();
		$(".filter_area_category option").hide();
		$(_class_view).show();
	});
	$(".edit_class").click(function(){
		$(".darken").fadeIn();
		$(".edit_area").show();
		$(".edit_area").animate({"left":"25%","opacity":"1"},0);
		id_record = $(this).attr("title");
		$(".hidden_id").val(id_record);
		//kaf_name = $(".kaf-"+id_record).attr("title");
		name_file = $("#rec-"+id_record).html();
		fak_name = $(".fak-"+id_record).attr("title");
		spec_name = $(".spec-"+id_record).attr("title");
		prof_name = $(".prof-"+id_record).attr("title");
		job_name = $(".job-"+id_record).attr("title");
		year_name = ($(".year-"+id_record).html())*1;
		razdel_name = $(".razdel-"+id_record).attr("title");
		class_view_edit = ".edit_fak_"+fak_name;
		$(".edit_area_select_spec option").hide();
		$(".edit_area_select_prof option").hide();
		$(".edit_area_select_job option").hide();
		$(class_view_edit).show();

		$(".edit_area_input_name").val( name_file );
		//$(".edit_area_select_kaf").val(kaf_name);
		$(".edit_area_select_fac").val(fak_name);
		$(".edit_area_select_spec").val(spec_name);
		$(".edit_area_select_prof").val(prof_name);
		$(".edit_area_select_job").val(job_name);
		$(".edit_area_select_year").val(year_name);
		$(".edit_area_select_razdel").val(razdel_name);

	});
	$(".delete_class").click(function(){
		$(".darken").show();
		$(".delete_question").show();
	});
	$(".edit_area_select_fac").change(function(){
		class_view_edit = ".edit_fak_"+$(this).val();
		$(".edit_area_select_spec option").hide();
		$(".edit_area_select_prof option").hide();
		$(".edit_area_select_job option").hide();
		$(".edit_area_select_spec").val(0);
		$(".edit_area_select_prof").val(0);
		$(".edit_area_select_job").val(0);

		$(class_view_edit).show();
	});

	$(".video_class").click(function(){
		id = $(this).attr("title");
		class_show = ".player_"+id;

		$(".darken").show();
		$(class_show).css({"display":"block"});
	});
});