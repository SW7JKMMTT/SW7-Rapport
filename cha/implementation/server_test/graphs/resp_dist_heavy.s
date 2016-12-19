set term epslatex size 5.00in, 3.50in
set output 'resp_dist_heavy.tex'
set ylabel 'Number of responses'
set xlabel 'Response times in ms'
set title ''
set xrange [0:1000]
set datafile separator ";"
set style fill solid 0.5
set boxwidth 10
set border 3
set format y "%.s%c"
set ytics out nomirror
set xtics out nomirror 0,40,1000 rotate by -45
unset key
set grid ytics lc rgb "#88607D8B" lw 1 lt 1
plot 'resp_dist_heavy.csv' using ($1 + 5):2 with boxes lc rgb "#03A9F4"
