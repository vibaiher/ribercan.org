set :application, "ribercan"
set :domain,      "vibaiher.com"
ssh_options[:port] = "8322"
set :deploy_to,   "/public_html/ribercan"
set :app_path,    "app"

set :scm,         :git
set :repository,  "git@github.com:vibaiher/ribercan.org.git"
set :deploy_via,  :copy

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :user_sudo,      false
set  :keep_releases,  3

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL
