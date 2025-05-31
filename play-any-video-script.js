<script>
  document.addEventListener("DOMContentLoaded", function () {
    const wrappers = document.querySelectorAll(".video-wrapper");

    wrappers.forEach(function (wrapper) {
      const link = wrapper.querySelector(".play-btn-wrap");
      const poster = wrapper.querySelector(".video-poster");
      const container = wrapper.querySelector(".video-container");
      let activeVideo = null;

      link.addEventListener("click", function (e) {
        e.preventDefault();

        const rawUrl = link.getAttribute("href");
        const type = detectVideoType(rawUrl);
        let embedUrl = rawUrl;
        let videoEl;

        if (type === "youtube") {
          embedUrl = getYouTubeEmbedURL(rawUrl);
          videoEl = document.createElement("iframe");
          videoEl.src = embedUrl;
          videoEl.allow = "autoplay; encrypted-media";
          videoEl.allowFullscreen = true;
          videoEl.frameBorder = "0";
          videoEl.style.width = "100%";
          videoEl.style.aspectRatio = "16 / 9";
        } else if (type === "vimeo") {
          embedUrl = getVimeoEmbedURL(rawUrl);
          videoEl = document.createElement("iframe");
          videoEl.src = embedUrl;
          videoEl.allow = "autoplay; fullscreen";
          videoEl.allowFullscreen = true;
          videoEl.frameBorder = "0";
          videoEl.style.width = "100%";
          videoEl.style.aspectRatio = "16 / 9";
        } else if (type === "video") {
          videoEl = document.createElement("video");
          videoEl.src = rawUrl;
          videoEl.controls = true;
          videoEl.autoplay = true;
          videoEl.style.width = "100%";
        } else {
          console.warn("Unsupported video format:", rawUrl);
          return;
        }

        container.appendChild(videoEl);
        if (poster) poster.style.display = "none";
        link.style.display = "none";
        activeVideo = videoEl;
      });

      // Pause video on tab switch
      document.addEventListener("visibilitychange", function () {
        if (document.hidden && activeVideo) {
          if (activeVideo.tagName === "VIDEO") {
            activeVideo.pause();
          } else if (activeVideo.tagName === "IFRAME") {
            activeVideo.contentWindow.postMessage(
              '{"event":"command","func":"pauseVideo","args":""}',
              '*'
            );
          }
        }
      });
    });

    function detectVideoType(url) {
      if (/youtube\.com|youtu\.be/.test(url)) return "youtube";
      if (/vimeo\.com/.test(url)) return "vimeo";
      if (/\.(mp4|webm|ogg)(\?.*)?$/.test(url)) return "video";
      return "unknown";
    }

    function getYouTubeEmbedURL(url) {
      const regExp = /(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
      const match = url.match(regExp);
      return match && match[1]
        ? `https://www.youtube.com/embed/${match[1]}?autoplay=1&enablejsapi=1`
        : null;
    }

    function getVimeoEmbedURL(url) {
      const regExp = /vimeo\.com\/(?:video\/)?(\d+)/;
      const match = url.match(regExp);
      return match && match[1]
        ? `https://player.vimeo.com/video/${match[1]}?autoplay=1`
        : null;
    }
  });
</script>
