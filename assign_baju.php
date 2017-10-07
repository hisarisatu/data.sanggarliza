<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>

<script>
            (function($) {
                $.widget("custom.combobox", {
                    _create: function() {
                        this.wrapper = $("<span>")
                                .addClass("custom-combobox")
                                .insertAfter(this.element);
                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                    },
                    _createAutocomplete: function() {
                        var selected = this.element.children(":selected"),
                                value = selected.val() ? selected.text() : "";
                        this.input = $("<input>")
                                .appendTo(this.wrapper)
                                .val(value)
                                .attr("title", "")
                                .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                                .autocomplete({
                                    delay: 0,
                                    minLength: 0,
                                   select: function( event, ui ) {
					$('#form_submited').submit();
					},
                                    source: $.proxy(this, "_source")
                                })
                                .tooltip({
                                    tooltipClass: "ui-state-highlight"
                                });
                        this._on(this.input, {
                            autocompleteselect: function(event, ui) {
                                ui.item.option.selected = true;
                                this._trigger("select", event, {
                                    item: ui.item.option
                                });
                            },
                            autocompletechange: "_removeIfInvalid"
                        });
                    },
                    _createShowAllButton: function() {
                        var input = this.input,
                                wasOpen = false;
                        $("<a>")
                                .attr("tabIndex", -1)
                                .attr("title", "Show All Items")
                                .tooltip()
                                .appendTo(this.wrapper)
                                .button({
                                    icons: {
                                        primary: "ui-icon-triangle-1-s"
                                    },
                                    text: false
                                })
                                .removeClass("ui-corner-all")
                                .addClass("custom-combobox-toggle ui-corner-right")
                                .mousedown(function() {
                                    wasOpen = input.autocomplete("widget").is(":visible");
                                })
                                .click(function() {
                                    input.focus();
        // Close if already visible
                                    if (wasOpen) {
                                        return;
                                    }
        // Pass empty string as value to search for, displaying all results
                                    input.autocomplete("search", "");
                                });
                    },
                    _source: function(request, response) {
                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                        response(this.element.children("option").map(function() {
                            var text = $(this).text();
                            if (this.value && (!request.term || matcher.test(text)))
                                return {
                                    label: text,
                                    value: text,
                                    option: this
                                };
                        }));
                    },
                    _removeIfInvalid: function(event, ui) {
        // Selected an item, nothing to do
                        if (ui.item) {
                            return;
                        }
        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                                valueLowerCase = value.toLowerCase(),
                                valid = false;
                        this.element.children("option").each(function() {
                            if ($(this).text().toLowerCase() === valueLowerCase) {
                                this.selected = valid = true;
                                return false;
                            }
                        });
        // Found a match, nothing to do
                        if (valid) {
                            return;
                        }
        // Remove invalid value
                        this.input
                                .val("")
                                .attr("title", value + " didn't match any item")
                                .tooltip("open");
                        this.element.val("");
                        this._delay(function() {
                            this.input.tooltip("close").attr("title", "");
                        }, 2500);
                        this.input.autocomplete("instance").term = "";
                    },
                    _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                    }
                });
            })(jQuery);
            $(function() {
                $(".combobox").combobox();
            });
            function aku(){
                alert('123');
            }
        </script>
        <style>
            .custom-combobox {
                position: relative;
                display: inline-block;
            }
            .custom-combobox-toggle {
                position: absolute;
                top: 0;
                bottom: 0;
                margin-left: -1px;
                padding: 0;
            }
            .custom-combobox-input {
                margin: 0;
                padding: 5px 10px;
            }
            *{
                font-size: 11px;
                color: black;
            }
            .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;   /* prevent horizontal scrollbar */
            overflow-x: hidden; /* add padding to account for vertical scrollbar */
            z-index:1000 !important;
        }
        </style>
<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010



include_once("include.php");

$n=mysql_query("select id_tipe_baju,id_baju,jml_baju,jml_kain,id_client,id_acara,id_paket,id_paket from client_busana where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus'");
$jml=mysql_num_rows($n);

//============================================================================================================================================================
if ($run != "")
{ 
	if ($jml == 0){
			$registerInvalid = 1;
			$runSQL = "insert into client_busana (id_client,id_acara,id_paket,id_plus,id_tipe_baju,id_baju,jml_baju,jml_kain)
			values('$id_client','$id_acara','$id_paket','$id_plus','$id_tipe_baju','$id_baju','$jml_baju','$jml_baju')";
			//echo $runSQL;
			$insert = mysql_query($runSQL, $connDB);
			$id = mysql_insert_id($connDB);
		} 
	else if ($jml != 0){
			$registerInvalid = 1;
			$runSQL = "update client_busana set id_baju='$id_baju',id_tipe_baju='$id_tipe_baju',jml_baju='$jml_baju' where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus' ";
			//echo $runSQL;
			$update = mysql_query($runSQL, $connDB);
		};//if
};
//============================================================================================================================================================

if ($run == ""){ 
	if ($jml != 0)
	{
		if($id_tipe_baju!="")
		{
			$id_tipe_baju=$id_tipe_baju;
		}
		else
		{
			$id_tipe_baju=mysql_result($n,0,"id_tipe_baju");
			$id_baju=mysql_result($n,0,"id_baju");
			$jml_baju=mysql_result($n,0,"jml_baju");
			$jml_kain=mysql_result($n,0,"jml_kain");
		}
	}

?>
        <form method="POST" name="form" id="form_submited" action="<?="?id_client=$id_client&id_acara=$id_acara&id_paket=$id_paket&id_plus=$id_plus";?>">
  <table border="0" cellspacing="0" cellpadding="0" align=left width="100%">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Update Baju</b></font>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr>
            <td width="35%" align="right">Kategori</td>
            <td width="65%"><select class="combobox" name="id_tipe_baju" onchange="aku()">
<?php
$sql="select id_tipe_baju,keterangan from p_baju_tipe where upper(keterangan) not like '%KAIN%' order by keterangan asc";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idp=mysql_result($rs,$a,"id_tipe_baju");
if ($idp==$id_tipe_baju)echo " selected ";
echo " value=\"$idp\">";
echo mysql_result($rs,$a,"keterangan");
echo "</option>";
} ?>
</select></td>
        </tr>
	<tr>
			<td width="35%" align="right">Jenis Baju</td>
                        <td width="65%"><select class="combobox" name="id_baju">
<?php
if(!isset($id_tipe_baju))$id_tipe_baju=1;
$sql="select id_layanan,layanan from p_baju where id_tipe_baju='$id_tipe_baju' order by layanan asc";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idl=mysql_result($rs,$a,"id_layanan");
if ($idl==$id_baju)echo " selected ";
echo " value=\"$idl\">";
echo mysql_result($rs,$a,"layanan");
echo "</option>";
} ?>
</select></td>
</tr>
	<tr>
			<td width="35%" align="right">Jml Baju</td>
            <td width="65%"><input type="text" name="jml_baju" value="<?=$jml_baju;?>" size="10"> <font color="#FF0000"><b>*</b></font></td>
        </tr>

<tr>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%">
			<input type="hidden" name="id" value="<?=$id;?>"><br>
			<input type="submit" value="Simpan" name="run" class="button">
      </td>
		</tr> </table>

   </td>
  </tr>
</table>
</form>
<?

} 
else 
{
//registerInvalid
?>

<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Update Data Busana</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <p>&nbsp;</p>
	 <a href="javascript:window.close();"><b>Tutup</b></a>
   </td>
  </tr>
</table>
<? } ?>