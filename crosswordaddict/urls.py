from django.conf.urls.defaults import *
from crosswordaddict import settings

# Uncomment the next two lines to enable the admin:
from django.contrib import admin
from crosswords.views import *
admin.autodiscover()

urlpatterns = patterns('',
    # Example:
    # (r'^crosswordaddict/', include('crosswordaddict.foo.urls')),

    # Uncomment the admin/doc line below and add 'django.contrib.admindocs' 
    # to INSTALLED_APPS to enable admin documentation:
    # (r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    (r'^admin/', include(admin.site.urls)),
    url(r'^$', index, name='home'),
    url(r'^crossword/(?P<id>\d+)$', crossword, name="crossword"),
    (r'^save/$', crossword_save),
    (r'^add-note/$', crossword_add_note),
    (r'^add-favorite/$', clue_add_favorite),
    (r'^all/$', list_crosswords),
    url(r'^/(?P<newspaper>\w+)/(?P<name>\w+)$', crossword_detail,name="crossword_detail"), # Ex: thc-9936, gc-24766
    (r'^/(?P<newspaper>\w+)/$', crossword_category), # Ex: thc, ft, custom
    (r'^create/$', create),
)

# Serves media content. WARNING!! Only for development uses.
# On production use lighthttpd for media content.
if settings.DEBUG:
    # Delete the first trailing slash, if any.
    if settings.MEDIA_URL.startswith('/'):
        media_url = settings.MEDIA_URL[1:]
    else:
        media_url = settings.MEDIA_URL

    # Add the last trailing slash, if have not.
    if not media_url.endswith('/'):
        media_url = media_url + '/'

    urlpatterns += patterns('',
        (r'^' + media_url + '(?P<path>.*)$', 'django.views.static.serve',
            {'document_root': settings.MEDIA_ROOT}
        ),
    )

                                                                
