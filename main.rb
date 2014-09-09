require 'sinatra'

#--------
# routing
#--------

enable :static
set :public_dir, 'public'

get '/' do
  send_file File.join(settings.public_dir, 'index.html')
end
