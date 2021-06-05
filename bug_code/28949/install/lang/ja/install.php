<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Automatically generated strings for Moodle installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.moodle.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['admindirname'] = 'Adminディレクトリ';
$string['availablelangs'] = '利用可能な言語一覧';
$string['chooselanguagehead'] = '言語を選択してください。';
$string['chooselanguagesub'] = 'インストールのみに使用する言語を選択してください。この言語は、サイトのデフォルト言語としても使用されます。サイト言語は、後で変更することが可能です。';
$string['clialreadyinstalled'] = 'ファイルconfig.phpは、すでに登録されています。あなたのサイトをアップグレードしたい場合、admin/cli/upgrade.phpを使用してください。';
$string['cliinstallheader'] = 'Moodle {$a} コマンドライン・インストールプログラム';
$string['databasehost'] = 'データベースホスト :';
$string['databasename'] = 'データベース名 :';
$string['databasetypehead'] = 'データベースドライバを選択する';
$string['dataroot'] = 'データディレクトリ';
$string['datarootpermission'] = 'データディレクトリパーミッション';
$string['dbprefix'] = 'テーブル接頭辞';
$string['dirroot'] = 'Moodleディレクトリ';
$string['environmenthead'] = 'あなたの環境を確認しています ...';
$string['environmentsub2'] = 'それぞれのMoodleリリースには、PHPバージョンの最小必要条件および多くの必須PHP拡張モジュールがあります。完全な環境チェックは、インストールおよびアップグレードごとに実行されます。新しいPHPバージョンのインストールまたはPHP拡張モジュールの有効化に関して分からない場合、あなたのサーバ管理者に連絡してください。';
$string['errorsinenvironment'] = '環境チェックが失敗しました!';
$string['installation'] = 'インストレーション';
$string['langdownloaderror'] = '残念ですが、言語「 {$a} 」がインストールされていません。インストール処理は英語で継続されます。';
$string['memorylimithelp'] = '<p>現在、サーバのPHPメモリー制限が {$a} に設定されています。</p>

<p>この設定ではMoodleのメモリーに関わるトラブルが発生する可能性があります。 特に多くのモジュールを使用したり、多くのユーザがMoodleを使用する場合にトラブルが発生します。</p>

<p>可能でしたら、PHPのメモリー制限上限を40M以上に設定されることをお勧めします。この設定を実現するために、いくつかの方法があります:
<ol>
<li>あなたがリコンパイル可能な場合、PHPを<i>--enable-memory-limit</i>オプションでコンパイルしてください。これにより、Moodle自身がメモリー制限を設定することが可能になります。</li>
<li>あなたがphp.iniファイルにアクセスできる場合、<b>memory_limit</b>設定を40Mのように変更することができます。php.iniファイルにアクセスできない場合、管理者に変更を依頼してください。</li>
<li>いくつかのPHPサーバでは、下記の行を含む.htaccessファイルをMoodleディレクトリに作成することができます:
<blockquote><div>php_value memory_limit 40M</div></blockquote>
<p>しかし、この設定が<b>すべての</b>PHPページの動作を妨げる場合もあります。ページ閲覧中にエラーが表示される場合、.htaccessファイルを削除してください。</p></li>
</ol>';
$string['paths'] = 'パス';
$string['pathserrcreatedataroot'] = 'データディレクトリ ({$a->dataroot}) は、インストーラーで作成できません。';
$string['pathshead'] = 'パスを確認する';
$string['pathsrodataroot'] = 'datarootディレクトリに書き込み権がありません。';
$string['pathsroparentdataroot'] = '親ディレクトリ ({$a->parent}) に書き込み権がありません。データディレクトリ ({$a->dataroot}) は、インストーラーで作成できません。';
$string['pathssubadmindir'] = '極わずかですが、あなたがコントロールパネル等にアクセスするため、特別なURIとして/adminを使用するウェブホストがあります。残念なことに、これはMoodle管理ページの標準的なローケーションと競合してしまいます。ここに新しいディレクトリ名を入力することで、あなたのMoodleのadminディレクトリを修正することができます。例えば、<em>moodleadmin</em>です。これにより、Moodleのadminリンクが修正されます。';
$string['pathssubdataroot'] = 'あなたには、Moodleがファイルをアップロードすることのできる場所が必要です。このディレクトリは、ウェブサーバユーザ (通常「nobody」または「apache」) から読み込みおよび「書き込み」できる必要があります。しかし、ウェブからは直接アクセスできないようにしてください。データディレクトリがない場合、インストーラーは作成を試みます。';
$string['pathssubdirroot'] = 'Moodleインストールに関するフルディレクトリパスです。';
$string['pathssubwwwroot'] = 'Moodleにアクセスすることのできるフルウェブアドレスです。複数アドレスを使用して、Moodleにアクセスすることはできません。あなたのサイトに複数のパブリックアドレスがある場合、このアドレスを除く、すべてのアドレスにパーマネントリダイレクトを設定してください。あなたのサイトにイントラネットおよびインターネットからアクセスできる場合、ここにはパブリックアドレスを入力してください。また、イントラネットユーザもパブリックアドレスを利用できるよう、DNSを設定してください。アドレスが正しくない場合、あなたのブラウザのURIを変更して、異なる値でインストールを再開してください。';
$string['pathsunsecuredataroot'] = 'dirrootロケーションが安全ではありません。';
$string['pathswrongadmindir'] = 'adminディレクトリがありません。';
$string['phpextension'] = '{$a} PHP拡張モジュール';
$string['phpversion'] = 'PHPバージョン';
$string['phpversionhelp'] = '<p>Moodleには、少なくとも 4.3.0 または 5.1.0 のPHPバージョンが必要です (5.0.x には既知の多数の問題があります)。</p>
<p>現在、バージョン {$a} が動作しています。</p>
<p>PHPをアップグレードするか、新しいバージョンがインストールされているホストに移動してください!<br />
(5.0.x の場合、バージョン 4.4.x にダウングレードすることもできます。)</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'インストールが正常に完了したため、このページが表示されています。
あなたのコンピュータで <strong>{$a->packname} {$a->packversion}</strong> パッケージを起動してください。
おめでとうございます!';
$string['welcomep30'] = 'このリリース <strong>{$a->installername}</strong> には、<strong>Moodle</strong> で環境を作成する次のアプリケーションが含まれています:';
$string['welcomep40'] = 'パッケージには <strong>Moodle {$a->moodlerelease} ({$a->moodleversion})</strong> も含まれています。';
$string['welcomep50'] = 'このパッケージ内のすべてのアプリケーションの使用は個々のライセンスによって規定されています。全体の <strong>{$a->installername}</strong> パッケージは <a href="http://www.opensource.org/docs/definition_plain.html">オープンソース</a> であり、<a href="http://www.gnu.org/copyleft/gpl.html">GPL</a>ライセンスの下に配布されています。';
$string['welcomep60'] = '次からのページは、あなたのコンピュータに<strong>Moodle</strong>を簡単に設定およびセットアップする手順にしたがって進みます。あなたはデフォルトの設定を使用することも、必要に応じて任意で設定を変更することもできます。';
$string['welcomep70'] = '<strong>Moodle</strong>のセットアップを続けるには「次へ」ボタンをクリックしてください。';
$string['wwwroot'] = 'ウェブアドレス';
