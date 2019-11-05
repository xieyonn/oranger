<?php

namespace Oranger\Command;

use Oranger\Library\Console\CommandBase;
use Oranger\Library\DI\DI;

class JsonCommand extends CommandBase
{
    public $a;

    protected $di;

    public function __construct()
    {
        $this->di = DI::getInstance();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public function indexAction()
    {
        $data = <<<EOL
{
  "access_type": "wifi",
  "aweme_coldstart": { "prob": 0.1544416696 },
  "blur": false,
  "camera": "0",
  "city": "Beijing",
  "city_code": "110000",
  "cold_start": 0,
  "country": "中国",
  "cover_vulgar": false,
  "creation_id": "9226a679-d0f4-48a4-976f-5f4982164239",
  "cv_info": "{\"gandalf_score\": 0.006369549315422773}",
  "daily_index": 0,
  "description_metas": [
    {
      "create_datetime": "2019-11-03T21:28:53+0800",
      "device_resolution": [],
      "import_path": "",
      "import_path_type": 0,
      "is_cropped": 0,
      "is_record": 1,
      "make": "Android",
      "md5": "",
      "system": "9",
      "user_device": "MI 8",
      "user_system": "9",
      "video_device": "",
      "video_duration": 4203,
      "video_resolution": { "height": 1280, "width": 720 }
    }
  ],
  "device_id": 61709490254,
  "device_info": "MI 8Xiaomi",
  "fake_action_type": 1,
  "file_fps": "29.0",
  "filter_id": "232646",
  "filter_name": "normal",
  "full_screen": 1,
  "gps_latitude": "39.977311",
  "gps_longitude": "116.330775",
  "h264_high_profile": 1,
  "image_age_predict": "",
  "in_audit_time": 1572787769,
  "install_id": 91077114205,
  "ip": "120.52.147.53",
  "ip_latitude": "0.000000",
  "ip_longitude": "0.000000",
  "is_hard_code": 11,
  "is_hash_tag": 1,
  "is_spring": 0,
  "item_comment": 0,
  "last_rate": 10,
  "last_status": 102,
  "mcc_mnc": "46000",
  "mute": 0,
  "openudid": "1f70f41d3f35e9ee",
  "original": 1,
  "os_version": "9",
  "pen": 0,
  "prettify": "3",
  "priority_region": "CN",
  "province": "北京",
  "rate": 12,
  "rate_source": "video_quality_filter",
  "region": "CN",
  "review_pending": "",
  "reviewed": 0,
  "speed": "3",
  "task": { "id": 6753937666963669005, "status": 1 },
  "text_language": "un",
  "transition_type": 0,
  "version_code": "8.6.0",
  "vulgar": false
}
EOL;
        $json = \json_decode($data, true);
        var_dump($json);
    }
}
