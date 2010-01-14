from django.forms.widgets import Input
from django.conf import settings
from django.utils.safestring import mark_safe
from django.db.models import get_model

class CrosswordWidget(Input):
    input_type = 'text'

    def render(self, name, value, attrs=None):
        html = '' # super(CrosswordWidget, self).render(name, value, attrs)
        grid_model = get_model('crosswords', 'CsPresets')
        csgrid = grid_model.objects.get(id=value).grid
        js = u"<script>drawCrossword( 15, 15 ); preset('%s');</script>" % (csgrid)
        return mark_safe("\n".join([html, js]))

    class Media:
        js_base_url = getattr(settings, 'TAGGING_AUTOCOMPLETE_JS_BASE_URL','%s/js' % settings.MEDIA_URL)
        css = {
            'all': ('%s/admin-crossword.css' % js_base_url,)
        }
        js = (
            '%s/cwsJS.js' % js_base_url,
            )
