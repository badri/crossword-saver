#!/usr/bin/env ruby
# sed -i 's/"\/resources\//"resources\//g'
# sed -i 's/"\/css\//"css\//g'
# sed -i 's/"\/js\//"js\//g'
if ARGV.length < 3 then
  puts "nsearch.rb monthly 20011 20153"
  exit
end
ctype = ARGV[0]
start_num = ARGV[1]
end_num = ARGV[2]

require "watir-webdriver"
browser = Watir::Browser.new :phantomjs
browser.goto "crosswordclub.co.uk"
browser.text_field(:name => 'username').set "<username>"
browser.text_field(:name => 'password').set "<password>"
browser.button(:value => 'Log in').click

(start_num..end_num).to_a.each do |num|
  browser.text_field(:name => 'number').set num
  browser.button(:value => 'Search').click
  browser.div(:class => 'singleRow').wait_until_present
  row = browser.div(:class => 'singleRow')
  title = row.div(:class => "searchResultsText").text()
  puts title
  cnum = title.split(' - ')[0]
  xword = row.div(:class => "pps").links[2]
  begin
    xword.click
    browser.windows.last.use
    crossword = browser.html
    if title.include? 'Saturday' then
      File.open("saturday-#{cnum}.html", 'w+b') { |file| file.puts(crossword) }
    else
      File.open("#{ctype}-#{cnum}.html", 'w+b') { |file| file.puts(crossword) }
    end
    browser.windows.last.close
    browser.div(:class => 'singleRow').wait_until_present
  end while crossword.length < 2000
end

