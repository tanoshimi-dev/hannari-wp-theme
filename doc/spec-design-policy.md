## design policy

reference: `doc/memo/sango-theme` (SANGO v2.13.0)

### color system

SANGOのカラーはカスタマイザー経由で設定可能。以下がデフォルト値。

| 項目 | setting key | default | 用途 |
|------|------------|---------|------|
| メインカラー | `main_color` | `#6bb6ff` | テーマ全体の主要色、見出し、ボタン、パンくず等 |
| 薄めの下地色 | `pastel_color` | `#c8e4ff` | 一部の背景、ページネーションhover等 |
| アクセントカラー | `accent_color` | `#ffb36b` | 検索アイコン、一部リスト装飾等 |
| リンク色 | `link_color` | `#4f96f6` | 記事内リンク (`a`タグ) |
| ヘッダー背景色 | `header_bc` | `#58a9ef` | ヘッダー、フッターメニュー、ドロワータイトル |
| ヘッダータイトル色 | `header_c` | `#FFF` | ロゴリンク色 |
| ヘッダーメニュー文字色 | `header_menu_c` | `#FFF` | ナビメニュー、フッターメニュー文字色 |
| ウィジェットタイトル色 | `wid_title_c` | `#6bb6ff` | サイドバー等ウィジェットタイトル文字色 |
| ウィジェットタイトル背景色 | `wid_title_bc` | `#c8e4ff` | サイドバー等ウィジェットタイトル背景色 |
| フッターウィジェット背景色 | `sng_footer_bc` | `#e0e4eb` | フッターウィジェットエリア背景 |
| フッターウィジェット文字色 | `sng_footer_c` | `#3c3c3c` | フッターウィジェット・リンク文字色 |
| body背景色 | `background_color` | `#eaedf2` | ページ全体の背景 (style.css) |
| body文字色 | — | `#252525` | 本文テキスト (style.css固定) |
| トップへ戻るボタン | `to_top_color` | `#5ba9f7` | 右下の戻るボタン |
| お知らせ欄テキスト色 | `header_info_c` | `#FFF` | ヘッダーお知らせバー文字 |
| お知らせ欄グラデ1 | `header_info_c1` | `#738bff` | お知らせバーのlinear-gradient開始色 |
| お知らせ欄グラデ2 | `header_info_c2` | `#85e3ec` | お知らせバーのlinear-gradient終了色 |
| モバイルフッター固定メニュー背景 | `footer_fixed_bc` | `#FFF` | モバイル下部固定メニュー背景 |
| モバイルフッター固定メニュー文字 | `footer_fixed_c` | `#a2a7ab` | モバイル下部固定メニュー文字色 |
| モバイルフッター固定アクティブ | `footer_fixed_actc` | `#6bb6ff` | モバイル下部固定メニューアクティブ色 |
| タブ背景色 | `tab_background_color` | `#FFF` | トップページタブ背景 |
| タブ文字色 | `tab_text_color` | `#a7a7a7` | トップページタブ文字 |
| タブアクティブグラデ1 | `tab_active_color1` | `#bdb9ff` | タブアクティブのlinear-gradient開始色 |
| タブアクティブグラデ2 | `tab_active_color2` | `#67b8ff` | タブアクティブのlinear-gradient終了色 |

CSSクラスによる色の適用:
- `.main-c` / `.main-bc` / `.main-bdr` — メインカラー(文字/背景/ボーダー)
- `.pastel-c` / `.pastel-bc` — 薄め下地色(文字/背景)
- `.accent-c` / `.accent-bc` — アクセントカラー(文字/背景)

### layout structure

```
<header>                          ← header_bc背景
  nav-drawer (モバイル)
  inner (ロゴ + デスクトップナビ)
</header>
info-bar                          ← お知らせ欄(グラデーション)
<div#content>
  <div#inner-content .wrap>       ← max-width制限のラッパー
    <main .m-all .t-2of3 .d-5of7> ← メインコンテンツ (7分の5幅)
    <sidebar .t-1of3 .d-2of7>     ← サイドバー (7分の2幅)
  </div>
</div>
<footer>                          ← footer_bc背景
  inner-footer (3カラム: left/center/right ウィジェット)
  footer-menu (HOME + ナビ + copyright)
</footer>
mobile-fixed-menu                 ← モバイル固定フッターメニュー
totop-button                      ← トップへ戻るボタン
```

グリッド: 7分割 (main=5/7, sidebar=2/7)
ブレークポイント: SP ≤480px / TB 481-1029px / PC ≥1030px

### typography

| デバイス | font-size default |
|----------|------------------|
| SP (≤480px) | 100% |
| TB (481-1029px) | 107% |
| PC (≥1030px) | 107% |

- 基本フォント: `Helvetica, Arial, Hiragino Kaku Gothic ProN, Hiragino Sans, YuGothic, Yu Gothic, メイリオ, Meiryo, sans-serif`
- 装飾フォント (`.dfont`): `Quicksand` + 基本フォント
- オプション: `Noto Sans JP`, `M PLUS Rounded 1c`
- line-height: `1.83`

### page templates

| ファイル | 用途 |
|---------|------|
| `index.php` | トップページ (タブ記事一覧 or グリッド) |
| `single.php` | 個別記事 |
| `page.php` | 固定ページ |
| `page-1column.php` | 1カラム固定ページ (サイドバーなし) |
| `page-forfront.php` | フロントページ用テンプレート |
| `page-forfront2col.php` | 2カラムフロントページ用テンプレート |
| `archive.php` | アーカイブ/カテゴリページ |
| `search.php` | 検索結果ページ |
| `404.php` | 404ページ |

### stylesheet (style.css) key patterns

#### base reset & defaults
- `box-sizing: border-box` (全要素)
- `body`: `margin:0`, `background-color:#eaedf2`, `color:#252525`, `line-height:1.83`
- `a`: `text-decoration:none`, `transition:0.3s ease-in-out`
- `a:hover`: `text-decoration:underline`
- input/textarea: `background-color:#eff1f5`, `border:0`, `border-radius:3px`

#### responsive grid system (float-based)
プレフィックス `.m-` / `.t-` / `.d-` でデバイスごとに幅を制御:

| breakpoint | prefix | media query |
|-----------|--------|-------------|
| モバイル | `.m-` | `max-width: 768px` |
| タブレット | `.t-` | `min-width: 769px` and `max-width: 1029px` |
| デスクトップ | `.d-` | `min-width: 1030px` |

グリッド例: `.d-5of7` = `width:69%`, `.d-2of7` = `width:31%`
`.wrap` = `width:92%; margin:0 auto` (コンテンツ幅の制限)

#### heading sizes
| tag | font-size | 備考 |
|-----|-----------|------|
| h1 | 1.35em | line-height: 1.6 |
| h2 | 1.3em | line-height: 1.56 |
| h3 | 1.2em | |
| h4 | 1.1em | |
| h5 | 1em | line-height: 1.5 |

記事内見出し (`.entry-content`):
- h2: `font-size:1.4em`, `margin:2.5em 0 0.7em`
- h3: `font-size:1.2em`, `border-left:4px solid {main_color}`, `padding:10px 0 10px 10px`
- h4: `font-size:1.1em`, `margin:2.3em 0 0.7em`

#### header
- `.header`: `position:relative`, `z-index:99`, `box-shadow:0 3px 6px rgba(0,0,0,.18)`
- `#logo`: `font-size:6vmin`, `text-align:center`, 高さ`62px`(デフォルト、カスタマイザーで変更可)
- `.mobile-nav`: 横スクロール可能なナビ、高さ`40px`
- `.desktop-nav`: モバイルでは `display:none`
- ドロワー(`#drawer__content`): `width:90%`, `max-width:330px`, CSS checkboxで開閉

#### content area
- `#content`: `margin-top:2em`, `padding-bottom:2em`
- `#entry`: `background-color:white`, `border-radius:3px`
- `.withspace`: `padding:0 15px`
- single/page: `#content`の`margin-top:0`、`#inner-content`は`width:100%`

#### background-color white adjustment
body背景が`#ffffff`の場合:
- `.post`, `.sidebar .widget`: `border:solid 1px rgba(0,0,0,.08)`
- `.sidebar .widget`: `border-radius:4px`, `overflow:hidden`
- `.sidelong__article`: `box-shadow:0 1px 4px rgba(0,0,0,.18)`

### card layout options

カスタマイザーで記事一覧カードのレイアウトを切り替え可能:
- `sidelong_layout` — PC トップページ横長カード
- `mb_sidelong_layout` — モバイル トップページ横長カード
- `archive_sidelong_layout` — PC アーカイブ横長カード
- `mb_archive_sidelong_layout` — モバイル アーカイブ横長カード
