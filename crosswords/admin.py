from django.contrib import admin
from django.db import models
from models import CsCrossword, CsPresets, CsClues
from forms import CrosswordInput

class CsCrosswordAdmin(admin.ModelAdmin):
    def save_model(self, request, obj, form, change):
        print request
        print obj
        print form
        print change
        obj.save()



admin.site.register(CsPresets)
admin.site.register(CsCrossword, CsCrosswordAdmin)
admin.site.register(CsClues)
