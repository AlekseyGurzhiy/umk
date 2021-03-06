<div class="logo"></div>
<div class="darken"></div>
<div class="instruction"><a href="doc/UMK.pdf" data-fancybox-type="iframe" class="pdf_class">1. Инструкция</a></div>
<div class="polozhenie"><a href="doc/Prikaz_178_ot_26.04.2013_Polozheenie_po_UMK.pdf" data-fancybox-type="iframe" class="pdf_class">2. Положение о УМК</a></div>
<div class="prikaz"><a href="doc/Prikaz.pdf" data-fancybox-type="iframe" class="pdf_class">3. Приказ о вводе в эксплуатацию</a></div>
<div class="raport"><a href="doc/Raport.docx">4. Форма рапорта на доступ</a></div>
<div class="google"><a href="doc/ChromeStandaloneSetup.exe">5. Скачать Google Chrome</a></div>

<!-- Поле для редактирования информации о файле -->

	<div class="edit_area">
		<div class="edit_area_close"></div>
		<h3 class="edit_area_title"> Редактирование </h3>
		<form id="formReloadInfo" action="index.php" method="post" enctype="multipart/form-data">
		<table class="edit_table">
			<tr class="edit_record">
				<td class="edit_cell_title">Имя файла:</td>
				<td class="edit_cell_value"><input type="text" class="edit_area_input_name" name="edit_area_input_name" value=""></td>
			</tr>

			<tr class="edit_record">
				<td class="edit_cell_title">Факультет:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_fac" name="edit_area_select_fac">
					<?php mysqli_data_seek($query_facultet, 0); ?>
					<?php while( $rows_facultet = mysqli_fetch_assoc($query_facultet) ){ ?>
					<option value="<?php echo $rows_facultet['id']?>"><?php echo $rows_facultet['name']?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="edit_record">
				<td class="edit_cell_title">Специальность:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_spec" name="edit_area_select_spec">
					<option value="0">Не выбрано...</option>
					<?php mysqli_data_seek($query_spec, 0); ?>
					<?php while( $rows_spec = mysqli_fetch_assoc($query_spec) ){ ?>
					<option class="edit_fak_<?php echo $rows_spec['id_facultet']?>" value="<?php echo $rows_spec['id']?>"><?php echo $rows_spec['name_spec']?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="edit_record">
				<td class="edit_cell_title">Профиль:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_prof" name="edit_area_select_prof">
					<option value="0">Не выбрано...</option>
					<?php mysqli_data_seek($query_profile, 0); ?>
					<?php while( $rows_profile = mysqli_fetch_assoc($query_profile) ){ ?>
					<option class="edit_fak_<?php echo $rows_profile['id_facultet']?>" value="<?php echo $rows_profile['id']?>"><?php echo $rows_profile['name']?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="edit_record">
				<td class="edit_cell_title">Раб.кат.:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_job" name="edit_area_select_job">
					<option value="0">Не выбрано...</option>
					<?php mysqli_data_seek($query_job, 0); ?>
					<?php while( $rows_job = mysqli_fetch_assoc($query_job) ){ ?>
					<option class="edit_fak_<?php echo $rows_job['id_kafedra']?>" value="<?php echo $rows_job['id']?>"><?php echo $rows_job['name']?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="edit_record">
				<td class="edit_cell_title">Год:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_year" name="edit_area_select_year">
					<?php for($i=0;$i<=20;$i++ ){ ?>
					<option value="<?php echo $this_year-$i;?>"> <?php echo $this_year-$i;?> </option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="edit_record">
				<td class="edit_cell_title">Раздел:</td>
				<td class="edit_cell_value">
				<select class="edit_area_select_razdel" name="edit_area_select_razdel">
					<?php mysqli_data_seek($query_section, 0); ?>
					<?php while( $rows_section = mysqli_fetch_assoc($query_section) ){ ?>
					<option value="<?php echo $rows_section['id']?>"><?php echo $rows_section['name']?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="edit_record">
				<td colspan="2" class="edit_cell_value">
					<input type="hidden" class="hidden_id" name="hidden_id_name" value="">
					<input type="submit" class="send_file" name="reload_value" value="Обновить">
				</td>
			</tr>
		</table>
	</form>
	</div>

<!-- Поле авторизации -->
<div class="autorization_area" >
	<div class="area_head">Введите логин и пароль</div>
	<form id="autorizForm" action="" method="post">
	<table>
		<tr>
			<td> Логин: </td>
			<td> <input type="text" name="autoriz_login" class="autoriz_login"> </td>
		</tr>
		<tr>
			<td> Пароль: </td>
			<td> <input type="password" name="autoriz_password"> </td>
		</tr>
	</table>
	<input type="submit" name="autoriz_submit" class="autoriz_submit" value="Авторизация">
	</form>
</div>