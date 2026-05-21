panel.plugin('1217/1217-video', {
  blocks: {
    '1217-video': {
      template: `
        <div class="b1217-video">
          <div style="display: flex; gap: 1rem;">
            <k-icon type="video" />
            <k-title>{{content.title}}</k-title>
          </div>

          <div>
            <template v-if="content.video_file.length > 0">
              <video  v-for="video_file of content.video_file"
                      class="b1217-video__video"
                      :src="video_file.url"
                      playsinline
                      autoplay
                      loop
                      muted
              />
            </template>
            <iframe :src="content.url"
                    v-else
                    class="b1217-video__iframe--vimeo"
                    frameborder="0"
                    allow="fullscreen; picture-in-picture" allowfullscreen/>
          </div>
        </div>
      `
    }
  }
});

const test = [
  {
    "content": {
      "video_file": [
        {
          "id": "231108_js_in-between_1920x1080_web.mp4",
          "image": {
            "back": "pattern",
            "color": "yellow-500",
            "cover": false,
            "icon": "video"
          },
          "info": "",
          "link": "/pages/projets+in-between/files/231108_js_in-between_1920x1080_web.mp4",
          "sortable": true,
          "text": "231108_js_in-between_1920x1080_web.mp4",
          "uuid": "file://rNKVO4cjwBiGVYF5",
          "dragText": "(video: 231108_js_in-between_1920x1080_web.mp4)",
          "filename": "231108_js_in-between_1920x1080_web.mp4",
          "type": "video",
          "url": "http://localhost:8000/media/pages/projets/in-between/337f2a710a-1779108726/231108_js_in-between_1920x1080_web.mp4"
        }
      ],
      "url": "",
      "credit": "",
      "title": "",
      "isfullwidth": false
    },
    "id": "b3100c50-2e4b-46d9-aeb4-c5d67fa3d1c5",
    "isHidden": false,
    "type": "1217-video"
  }
]
