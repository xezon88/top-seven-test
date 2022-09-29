jQuery(function($) {
  /*
   * действие при нажатии на кнопку загрузки изображения
   * вы также можете привязать это действие к клику по самому изображению
   */
  $('.select_image_button').click(function() {

    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    wp.media.editor.send.attachment = function(props, attachment) {
      $(button).parent().prev().attr('src', attachment.url);
      $(button).prev().val(attachment.id);
      wp.media.editor.send.attachment = send_attachment_bkp;
    }
    wp.media.editor.open(button);
    return false;
  });
  /*
   * удаляем значение произвольного поля
   * если быть точным, то мы просто удаляем value у input type="hidden"
   */
  $('.remove_image_button').click(function() {
    var r = confirm("Уверены?");
    if (r == true) {
      var src = $(this).parent().prev().attr('data-src');
      $(this).parent().prev().attr('src', src);
      $(this).prev().prev().val('');
    }
    return false;
  });
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