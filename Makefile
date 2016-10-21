LATEX=lualatex

LATEXOPT=--shell-escape --synctex=1
NONSTOP=--interaction=nonstopmode

LATEXMK=latexmk
LATEXMKOPT=-pdf
CONTINUOUS=-pvc

MAIN=main
SUBDIRS :=
CHA_SOURCE := $(shell find cha -type f -iname "*.tex")
SOURCES=$(MAIN).tex Makefile $(CHA_SOURCE)
BIB_SOURCES := $(shell find . -type f -iname "*.bibpart")
#FIGURES := $(shell for dir in "$(SUBDIRS)"; do find $$dir/img $$dir/fig -type f; done;)

all: once

.refresh:
	touch .refresh

force:
	touch .refresh
	rm -f $(MAIN).pdf
	$(LATEXMK) $(LATEXMKOPT) $(CONTINUOUS) \
		-pdflatex="$(LATEX) $(LATEXOPT) %O %S" $(MAIN)

clean:
	$(LATEXMK) -C $(MAIN)
	rm -f bibtex.bib

once: $(MAIN).tex .refresh $(SOURCES) $(FIGURES) bibtex.bib
	$(LATEXMK) $(LATEXMKOPT) -pdflatex="$(LATEX) $(LATEXOPT) $(NONSTOP) %O %S" $(MAIN) \
		|| rubber-info $(MAIN)

continuous: $(MAIN).tex .refresh $(SOURCES) $(FIGURES) bibtex.bib
	$(LATEXMK) $(LATEXMKOPT) $(CONTINUOUS) \
		-pdflatex="$(LATEX) $(LATEXOPT) $(NONSTOP) %O %S" $(MAIN)

debug: once
	rubber-info $(MAIN)

bibtex.bib: $(BIB_SOURCES)
	cat $^ > bibtex.bib

lint:
	chktex -v0 $(shell find . -type f -name "*.tex")

test: clean bibtex.bib
	latexmk -pdf -pdflatex="echo X | lualatex --draftmode --shell-escape --interaction=errorstopmode %O %S \; touch %D" $(MAIN)

.PHONY: clean force once debug lint continuous test all
