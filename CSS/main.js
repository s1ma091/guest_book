var img =  document.querySelector('.img');
document.addEventListener('click', function showImg(event){
    if(event.target.className == 'n'){
     if(  img.style.height == '250px' ){
        setTimeout(function(){  img.style.height = '0';
        img.style.opacity = '0'
    },500)
    event.target.style.color = ''
     } else {
           setTimeout(function(){  img.style.height = '250px'; 
           img.style.opacity = '1'
    },500)
        event.target.style.color = '#8b0000'
    }
    }
})
