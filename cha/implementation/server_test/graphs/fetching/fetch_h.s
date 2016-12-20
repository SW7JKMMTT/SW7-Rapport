set term epslatex size 5.50in, 4.00in
set output 'fetch_heavy.tex'
set xdata time
set timefmt "%H:%M:%S,0"
set ylabel 'Response times in ms' offset 2
set xlabel 'Elapsed time [minutes:seconds]'
set title ''
set datafile separator ";"
set border 3
set ytics out nomirror
set xtics out nomirror rotate by -45
set format x "%M:%S"
set key above width -15 vertical maxrows 3
set grid ytics lc rgb "#88607D8B" lw 1 lt 1
plot 'all_users_heavy.csv' using 1:2 with lines t 'All users 2067.54 MB' lc rgb "#263238" lw 3,\
     'all_routes_heavy.csv' using 1:2 with lines t 'All routes 713.18 MB' lc rgb "#1B5E20" lw 3,\
     'routes_4_driver_heavy.csv' using 1:3 with lines t 'Routes for random drivers 2.5 MB' lc rgb "#BF360C" lw 3,\
     'all_vehicles_heavy.csv' using 1:2 with lines t 'All vehicles 638.57 MB' lc rgb "#0D47A1" lw 3,\
     'geospatial_heavy.csv' using 1:2 with lines t 'Geospatial 5.26 MB' lc rgb "#4A148C" lw 3
