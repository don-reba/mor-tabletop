require 'sinatra'

#--------
# routing
#--------

enable :static

get '/' do
  redirect '/index.html'
end
