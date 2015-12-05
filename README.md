## Social share plugin for Shaarli

For each link in your Shaarli, adds links to share your bookmarks to main social networks or by email (mailto).

### Installation/configuration
Clone this repository inside your `tpl/plugins/` directory, or download the archive and unpack it there.  
The directory structure should look like:

```
└── tpl
    └── plugins
        └── social
            ├── README.md
            ├── social.php
            ├── social.html
            └── social.css
```

To enable the plugin, add `'social'` to your list of enabled plugins in `data/options.php` (`PLUGINS` array)
. This should look like:

```
$GLOBALS['config']['PLUGINS'] = array('qrcode', 'any_other_plugin', 'social')
```
