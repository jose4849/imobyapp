<script>
            function fullscreen() {
                //alert("hello");
                
                $('a').click(function() {
                    if(!$(this).hasClass('noeffect')) {
                        var link = (this);
                       // alert(link);
                        if(link==''){
                            
                        }
                        else{
                            window.location = $(this).attr('href');
                        }
                        //
                        return false;
                    }
                }); 
            }
            fullscreen();
</script>
<div class="row text-c">
    <div class="l-12  copy_right">
        Copyright 2014 Imoby B.V.
        <!--Copyright 2014 <?= $informatie[0]->name ?>-->
    </div>
</div>