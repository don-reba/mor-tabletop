require 'sinatra'

#--------
# routing
#--------

enable :static

get '/' do
  send_file 'index.html'
end
