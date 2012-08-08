/*	
Template Name: Adminium
Description: Modern admin panel interface
Version: 1.2
Author: enstyled
Author URI: http://themeforest.net/user/enstyled
 */

$(function () {

    // Collapsable navigation	
    $('ul#nav .collapse:not(.open)').parents('li').find('ul').hide();
	
    $('ul#nav .collapse').click(function() {
        if( ! $(this).hasClass('open') ) {
            $(this).parents('li').find('ul').stop(true, true).slideDown('fast');
            $(this).addClass('open');
        } else {
            $(this).parents('li').find('ul').stop(true, true).slideUp('fast');
            $(this).removeClass('open');
        }	
        return false;
    }
);
	
  
    // Check / uncheck all checkboxes
    $(".check_all").click(function(){
        $(this).closest('table').find(':checkbox').not("[disabled]").attr('checked', this.checked);
    });
  
    // Sort table
    $('table.sortable tr th.header').css('cursor', 'pointer');
	
  
    // Table delete row confirmationalert("asdsa");
    function tiklama(obj, n){
        var id = $(obj).attr('alt');
        if (confirm("Silmek istediğinizden emin misiniz? Bu işlem geri getirilemez.")) {
            //			function ttt(){
            $.ajax({
                type: 'POST',
                url: 'inc/sil.php',
                data: 'id='+id+'&n='+n,
                success: function(e){},
                error: function(e){}
                });
                //			}
						
                $(obj).parents('tr').fadeOut('slow', function() {
                    $(obj).remove();
                    //ttt(id)
                    hudMsg('success',"Silme işlemi başarılı bir şekilde gerçekleşmiştir.", 3000);
                });
            }
            //return false;
        }

        function tiklama2(obj, n){
            if (n != 1) {
                var id = $(obj).attr('alt');/*1, urun kategori bilgisine denk geliyor. id direk yollandigi icin buna gerek yok */
            }
            else{
                var id = obj
            }
            if(id != 1){
                if (confirm("Silmek istediğinizden emin misiniz? Bu işlem geri getirilemez.")) {
                    $.ajax({
                        type: 'POST',
                        url: 'inc/altsil.php',
                        data: 'id='+id+'&n='+n,
                        success: function(e){},
                        error: function(e){}
                    });
                    $(obj).parents('tr').fadeOut('slow', function() {
                        $(obj).remove();
                        hudMsg('success',"Silme işlemi başarılı bir şekilde gerçekleşmiştir.", 3000);
                    });
                }
            }
        };
        function tiklama3(obj, n){
            var id = $(obj).attr('alt');
            var icerik = $(obj).attr('ana');
            if (confirm("Silmek istediğinizden emin misiniz? Bu işlem geri getirilemez.")) {
                //			function ttt(){
                $.ajax({
                    type: 'POST',
                    url: 'inc/sil.php',
                    data: 'id='+id+'&n='+n,
                    success: function(cevap){
                        alert("İçerik Başarılı Bir Şekilde Silindi"),
                        adres = window.location.pathname;
                        sorgu = '?duzelt='+icerik+'&sil=1';
                        son_adres = (adres + ' ' + sorgu);
                        window.location.replace(''+ son_adres +'')//Burada yönlendirme olayı var
                    },
                    error: function(e){
                        alert("İçerik Silinirken Bir Hata Oluştu!!!"),
                        adres = window.location.pathname;
                        sorgu = '?duzelt='+icerik+'&sil=2';
                        son_adres = (adres + ' ' + sorgu);
                        window.location.replace(''+ son_adres +'')//Burada yönlendirme olayı var
                    }
                });
                //			}
						
                $(obj).parents('tr').fadeOut('slow', function() {
                    $(obj).remove();
                    //ttt(id)
                    hudMsg('success',"Silme işlemi başarılı bir şekilde gerçekleşmiştir.", 3000);
                });
            }
            //return false;
        }
        $('.pg').click(function(){
            tiklama(this, '1');
            location.href="pages.php";
            return false;
        });	

        $('.pc').click(function(){
            tiklama2(this, '2');
            return false;
        });
	
        $('.ps').click(function(){
            tiklama(this, '3');
            location.href="posts.php";
            return false;
        });
	
        $('.mr').click(function(){
            tiklama(this, '4');
            location.href="brands.php";
            return false;
        });

        $('.ur').click(function(){
            tiklama(this, '5');
            location.href="products.php";
            return false;
        });

        $('.al').click(function(){
            tiklama(this, '6');
            location.href="galleries.php";
            return false;
        });

        $('.lc').click(function(){
            tiklama(this, '7');
            location.href="link-categories.php";
            return false;
        });
	
        $('.ln').click(function(){
            tiklama(this, '8');
            location.href="links.php";
            return false;
        });	

        $('.kl').click(function(){
            tiklama(this, '9');
            return false;
        });

        $('.ph').click(function(){
            tiklama3(this, '10');
            return false;
        });

        $('.sl').click(function(){
            tiklama(this, '11');
            location.href="slide.php";
            return false;
        });   

        $('.aa').click(function(){
            var id = $(this).attr('alt');
            $.ajax({
                type: 'POST',
                url: 'inc/urunKontrol.php',
                data: 'id=-'+id+'-',
                success: function(e){
                    if (e >= 1){
                        alert("Bu kategoride yazı bulunuyor. Lütfen kategoriyi silmek için, önce kategorideki yazıları başka bir kategoriye taşıyın.")
                    }
                    else{
                        tiklama2(id, '1');
                    }
                },
                error: function(e){}
            });
            return false;
        });

        // Messages
        $('#content .message').hide().append('<span class="close" title="Dismiss"></span>').fadeIn('slow');
        $('#content .message .close').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
		
        $('#content .message .close').click(function() {
            $(this).parent().fadeOut('slow', function() {
                $(this).remove();
            });
        });
	
        // Custom file input
        $('input.file.styled').each(function() {
            var custom_file_label = $(this).attr('title');
            $(this).wrap('<span class="custom_file" />');
            $(this).parents('.custom_file').append('<input type="button" class="button" value="'+custom_file_label+'" />');
        });
	
        $('.custom_file input:button').live('click', function() {
            $(this).parents('span').find('input:file').click();
        });
	
        $('.custom_file input.file').change(function() {
            $(this).parents('span').find('em').remove();
            var filename = $(this).val().replace(/^.*\\/, '');
            $(this).parents('span').append('<em>' + filename + '</em>');
        });
	
        // Sortable images
        $('ul.imglist').sortable({
            placeholder: 'ui-state-highlight'
        });
	
        // Image actions menu
        $('ul.imglist li').hover(
        function() {
            $(this).find('ul').css('display', 'none').stop(true, true).fadeIn('fast').css('display', 'block');
        },
        function() {
            $(this).find('ul').stop(true, true).fadeOut(100);
        }
    );

    });