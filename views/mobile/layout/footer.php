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

</body>
</html>