# config valid only for current version of Capistrano
lock '3.4.0'

set :application, 'ribercan'
set :repo_url, 'git@github.com:vibaiher/ribercan.org.git'

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push('app/config/parameters.yml')

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push('web/images/dogs', 'web/images/news', 'web/images/products', 'web/images/events')

# Default value for keep_releases is 5
set :keep_releases, 1

namespace :deploy do
  after :starting, 'composer:install_executable'

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end
end
