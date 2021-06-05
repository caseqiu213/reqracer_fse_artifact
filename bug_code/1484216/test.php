/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

db_delete('cache_update')
  ->execute();

module_load_include('inc', 'update', 'update.compare');
$projects = update_get_projects();
foreach ($projects as $key => $project) {
  update_create_fetch_task($project);
}