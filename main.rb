require 'sinatra'

#--------
# routing
#--------

enable :static
set :public_dir, '.'

get '/' do
  send_file File.join(settings.public_dir, 'index.html')
end
