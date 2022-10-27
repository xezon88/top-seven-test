jQuery('.slider__home').slick({
  dots: true,
  infinite: true,
  speed: 500,
  fade: true,
  arrows: false,
  cssEase: 'linear'
});

function findVideos() {
  let video = document.querySelector('.video');


  setupVideo(video);

}

function setupVideo(video) {

  let media = video.querySelector('#video__img');
  let preview = video.querySelector('.video__preview');
  let button = video.querySelector('.video__button');
  let id = parseMediaURL(media);

  video.addEventListener('click', () => {
    let iframe = createIframe(id);

    media.remove();
    button.remove();
    preview.appendChild(iframe);
  });

}

function parseMediaURL(media) {
  let regexp = /https:\/\/i\.ytimg\.com\/vi\/([a-zA-Z0-9_-]+)\/hqdefault\.jpg/i;
  let url = media.src;
  let match = url.match(regexp);

  return match[1];
}

function createIframe(id) {
  let iframe = document.createElement('iframe');

  iframe.setAttribute('allowfullscreen', '');
  iframe.setAttribute('width', '100%');
  iframe.setAttribute('height', '100%');
  iframe.setAttribute('allow', 'autoplay');
  iframe.setAttribute('src', generateURL(id));
  iframe.classList.add('video__media');

  return iframe;
}

function generateURL(id) {
  let query = '?rel=0&showinfo=0&autoplay=1';

  return 'https://www.youtube.com/embed/' + id + query;
}

findVideos();

jQuery(function($) {
  $(window).on('load', function() {
    $('body').on('click', function(e) {

      if (e.target.nodeName == 'TEXTAREA') {
        $('.placeholder').css("opacity", "0");
      } else {
        $('.placeholder').css("opacity", "1");
      }

    });

  });

  let wpcf7Elm = document.querySelector('#wpcf7-f97-o2');

  wpcf7Elm.addEventListener('wpcf7mailsent', function(event) {

    let close = document.querySelector('.close-window');

    close.style.opacity = 0;

    let newDiv = document.createElement('div');

    newDiv.className = 'wpcf7-response-output';

    wpcf7Elm.appendChild(newDiv);

    $('.wpcf7-response-output').html('<div class="content-success"><p>DONE!</p><p>We will soon get back to you.</p></div><div class="close-window"></div>');



  }, false);

  let buttons = document.getElementsByClassName('slide__button');

  let modal = document.getElementById('form-modal');

  for (let i = 0; i < buttons.length; i++) {

    const button = buttons[i];

    button.addEventListener('click', function(e) {

      e.preventDefault;

      modal.classList.remove('hid');

      modal.classList.add('open');

      $('body').css("overflow", "hidden");

      let close = document.querySelector('.close-window');

      close.style.opacity = 1;

    });
  }

  document.addEventListener('click', function(e) {

    let success = document.getElementsByClassName('wpcf7-response-output');

    if (e.target.classList.contains('close-window') || e.target.classList.contains('form-modal')) {

      modal.classList.remove('open');

      modal.classList.add('hid');





      $('body').css("overflow", "visible");
      $('.output-modal').hide();
      if (success) {
        for (let i = 0; i < success.length; i++) {
          const element = success[i];
          element.remove();

        }

      }

    }

  });

  let wpcf7El = document.querySelector('.contact-form');

  document.addEventListener('wpcf7mailsent', function(event) {

    let close = document.querySelector('.close-window');



    let newDiv = document.createElement('div');

    newDiv.className = 'output-modal';

    wpcf7El.appendChild(newDiv);

    $('.output-modal').html('<div class="wpcf7-response-output"><div class="content-success"><p>THANK YOU!</p><p>We will be in touch very soon.</p></div><div class="close-window"></div></div>');



  }, false);

  var btn = $('.up');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 500) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, '300');
  });




});