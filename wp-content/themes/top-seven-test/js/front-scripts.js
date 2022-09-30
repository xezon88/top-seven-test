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


jQuery(window).on('load', function() {
  jQuery('.textarea-message').on('input', function() {
    if (jQuery(this).val().length > 0) {
      jQuery('.placeholder').css("opacity", "0");
    } else {
      jQuery('.placeholder').css("opacity", "1");
    }
  });
});