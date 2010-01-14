from django.contrib import admin
from django.db import models
from models import CsCrossword, CsPresets, CsClues
from forms import CrosswordInput

# class CsCrosswordAdmin(admin.ModelAdmin):


admin.site.register(CsPresets)
admin.site.register(CsCrossword)
admin.site.register(CsClues)
