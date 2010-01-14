from django import forms
from models import CsCrossword, CsPresets

class CrosswordInput(forms.TextInput):
    class Media:
        js = ('cwsJS.js')

    def render(self, name, value, attrs=None):
        output = super(CrosswordInput, self).render(name, value, attrs)
        return output + "<b> %s </b>" % (CsPresets.objects.get(id=value).grid)
