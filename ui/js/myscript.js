$(function() { 
    audiojs.events.ready(function() {
        var a = audiojs.createAll(
            {
                trackEnded: function() {
                    var next = $('ol li.playing').next();
                    if (!next.length) next = $('ol li').first();
                    next.addClass('playing').siblings().removeClass('playing');
                    audio.load($('a', next).attr('data-src'));
                    audio.play();
                    $('.track-details').html($('a', next).html());
                }
            }
        ),
        audio = a[0],
        ids = ['vol-0', 'vol-10', 'vol-40', 'vol-70', 'vol-100'];
            
        for (var i = 0, ii = ids.length; i < ii; i++) {
            var elem = document.getElementById(ids[i]),
            volume = ids[i].split('-')[1];
            if(elem){
                elem.setAttribute('data-volume', volume / 100)
                elem.onclick = function(e) {
                    audio.setVolume(this.getAttribute('data-volume'));
                    e.preventDefault();
                    return false;
                }
            }
        };

        var audio = a[0];
        if(audio){
            first = $('ol a').attr('data-src');
            $('ol li').first().addClass('playing');
            audio.load(first);

            $('ol li').click(function(e) {
                e.preventDefault();
                $(this).addClass('playing').siblings().removeClass('playing');
                audio.load($('a', this).attr('data-src'));
                audio.play();

                $('.track-details').html($('a', this).html());
            });
        }
    });
         
    var carousel = document.getElementById('carousel');
    if(carousel){
        $('#carousel').carouFredSel(
            {
                items: 5,
                prev: '#prev',
                next: '#next',
                auto: false
            },
            {
                debug: true
            }
        ); 
    }       
});

function filesInputHandler(fileList,id) {
    var filename = fileList[0].name;
    var file = filename.substring(0,filename.length -4);
    if(document.getElementById(id).value=='') {
        document.getElementById(id).value = file;
    }
}
      
