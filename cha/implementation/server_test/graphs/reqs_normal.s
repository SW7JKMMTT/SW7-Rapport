set term epslatex size 5.00in, 3.50in
set xdata time
set timefmt "%H:%M:%S,0"
set output 'reqs_normal.tex'
set ylabel 'Number of requests per second'
set xlabel 'Elapsed time in minutes'
set title ''
set datafile separator ";"
set border 3
set ytics out nomirror
set xtics out nomirror rotate by -45
set format x "%M"
unset key
set grid ytics lc rgb "#88607D8B" lw 1 lt 1
plot 'reqs_normal.csv' using 1:2 with lines lc rgb "#03A9F4" lw 2
