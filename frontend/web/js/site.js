$(document).ready(function(){


    // Making active tab works
    $loc= $(location).attr('search').substr(3).split('%2F');
    
    if($loc[0] == 'product' && $loc[1] =='set')
    {
        $('.nav-set').addClass('active');
    }
    if($loc[0] == 'product' && $loc[1] =='shop')
    {
        $('.nav-shop').addClass('active');
    }



    $('.modal-confirm').click(function(ev){

        var pid=$(ev.target).closest('.modal-content').find('#product_id').attr('value');
        var qty=$(ev.target).closest('.modal-content').find('#product_qty').val();
        var m_array=[];
        var mqty=$(ev.target).closest('.modal-content').find('.m_qty');
        
       
        mqty.each(function(){
                if(parseInt($(this).text()) != 0)
                {
                    var mid=$(this).closest('.modifier_card').attr('data-key');
                    var m_qty=parseInt($(this).text());
                    m_array.push({'modifier_id':mid,'modifier_qty':m_qty});

                }
        })
        
        $.ajax({url:'index.php?r=product%2Fcart',data:{'pid':pid,'qty':qty,'modifiers':m_array},
        success: function(resp){

            $('#cart_section').html(resp);
            
        }
        });
    })

    $('.m_add').click(function(){
        var m_qty=$(this).closest('.card-body').find('.m_qty');

        m_qty.text(parseInt(m_qty.text())+1);   


    })


    $('.m_minus').click(function(){
        var m_qty=$(this).closest('.card-body').find('.m_qty');
        var m_qty_value = $(this).closest('.card-body').find('.m_qty').text();
        // Not allowing negative values 
        if(parseInt(m_qty_value)-1 < 0)
        {
            alert("Negative values are not allowed");
        }
        else
        {
            m_qty.text(parseInt(m_qty.text())-1); 
        }
          


    })


    $('.set-confirm').click(function(ev){
        
        var sid=$(ev.target).closest('.card-body').find('.sid').attr('value');
        var qty=$(ev.target).closest('.card-body').find('.s_qty').val();
        

        $.ajax({url:'index.php?r=product%2Fsetadd',data:{'sid':sid,'qty':qty},
        success: function(resp){

            $('#cart_section').html(resp);
            
        }
        });
    })



})


