$(function () {

  _init();
  let arrayTemp = [];

  function _init() {
    dibujarKpiInicio();
    filtrarData();
  }


  function dibujarKpiInicio() {
    $.ajax({
      url: urlServidor + '/citas/indicadoresGlobales',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        if (response.status) {
          console.log(response.data)
          positivo = response.data.satifaccionPaciente.positivo.csat_porcentaje;
          negativo = response.data.satifaccionPaciente.negativo.csat_porcentaje;
          $('#valPositivo').html(response.data.satifaccionPaciente.positivo.rango);
          $('#csatPositivo').html(response.data.satifaccionPaciente.positivo.csat_promedio);
          $('#valNegativo').html(response.data.satifaccionPaciente.negativo.rango);
          $('#csatNegativo').html(response.data.satifaccionPaciente.negativo.csat_promedio);

          campanias = response.data.campanias;
          let array = response.data.estadosCitas.serie;
          let series = armarSeries(array);
          graficarSeries(series);

          renderKpiSatisfaccion(positivo, negativo);
          renderTiempoEspera30(response.data.timePaciente.time30);
          renderTiempoEspera60(response.data.timePaciente.time60);

          if (campanias.length > 0) {
            $('#msjNoInfo').html('');
            $('#box-canva1').empty();

            for (let i = 0; i < campanias.length; i++) {
              const element = campanias[i];
              let id_canvas = `chart-canvas-${i + 1}`;
              let canvas = `<div id="${id_canvas}" class="ocultar" style="width:max-width: 250px;height: 400px;"></div>`;
              $('#box-canva1').append(`<div class="col-md-4 col-sm-6">${canvas}</div>`); //'<div>hello</div>'

              renderGraficoCampanias(element, id_canvas);
            }
          } else {
            $('#box-canva1').empty();
            $('#msjNoInfo').html('No existe Información de Campañas de Vacunación');
          }
        } else {
          Toast.fire({
            icon: 'info',
            title: 'No hay informacion disponible'
          })
        }
      }
    });
  }

  function renderKpiSatisfaccion(positivo, negativo) {
    var palette = ['#EE6352', '#FFE853', '#AAF78B'];

    var value1 = positivo;

    var chartPos = new JSC.chart('chartDivPos', {
      legend_visible: false,
      palette: {
        pointValue: '%yValue',
        ranges: [
          { value: [0, 30], color: palette[0] },
          { value: [30, 70], color: palette[1] },
          { value: [70, 100], color: palette[2] }
        ]
      },
      xAxis: [
        {
          id: 'xAx1',
          scale: { range: [0, 1] }
        },
      ],
      yAxis: [
        {
          id: 'yAx1',
          defaultTick: {
            padding: 13,
            label_visible: false,
            enabled: false
          },
          line: {
            width: 10,
            breaks_gap: 0.03,
            color: 'smartPalette'
          },
          scale: { range: [0, 100], interval: 10 }
        },
        {
          id: 'yAx2',
          defaultTick: {
            padding: 13,
            label_visible: false
          },
          line: {
            width: 22,
            // breaks_gap:.03,
            color: 'smartPalette'
          },
          scale: { range: [0, 100], interval: 10 }
        },
      ],
      defaultTooltip_enabled: false,
      defaultSeries: {
        type: 'gauge marker',
        opacity: 1,
        shape: {
          size: '86%',
          padding: 0,
          label: {
            text: '%sum%',
            align: 'center',
            verticalAlign: 'middle',
            offset: '0,10',
            style: { fontSize: '14px' }
          }
        }
      },
      defaultPoint: {
        marker: { type: 'circle', outline: { width: 8 } }
      },
      series: [
        {
          yAxis: 'yAx2',
          xAxis: 'xAx1',
          defaultPoint: {
            marker: {
              outline: { color: 'white' },
              fill: 'none',
              size: 28
            }
          },
          points: [{ id: 'value1', x: 0, y: value1 }]
        },
      ]
    });


    var palette = ['#AAF78B', '#FFE853', '#EE6352'];
    var value1 = negativo;
    var chartNeg = new JSC.chart('chartDivNeg', {
      legend_visible: false,
      palette: {
        pointValue: '%yValue',
        ranges: [
          { value: [0, 30], color: palette[0] },
          { value: [30, 70], color: palette[1] },
          { value: [70, 100], color: palette[2] }
        ]
      },
      xAxis: [
        {
          id: 'xAx1',
          scale: { range: [0, 1] }
        },
      ],
      yAxis: [
        {
          id: 'yAx1',
          defaultTick: {
            padding: 13,
            label_visible: false,
            enabled: false
          },
          line: {
            width: 10,
            breaks_gap: 0.03,
            color: 'smartPalette'
          },
          scale: { range: [0, 100], interval: 10 }
        },
        {
          id: 'yAx2',
          defaultTick: {
            padding: 13,
            label_visible: false
          },
          line: {
            width: 22,
            // breaks_gap:.03,
            color: 'smartPalette'
          },
          scale: { range: [0, 100], interval: 10 }
        },
      ],
      defaultTooltip_enabled: false,
      defaultSeries: {
        type: 'gauge marker',
        opacity: 1,
        shape: {
          size: '86%',
          padding: 0,
          label: {
            text: '%sum%',
            align: 'center',
            verticalAlign: 'middle',
            offset: '0,10',
            style: { fontSize: '14px' }
          }
        }
      },
      defaultPoint: {
        marker: { type: 'circle', outline: { width: 8 } }
      },
      series: [
        {
          yAxis: 'yAx2',
          xAxis: 'xAx1',
          defaultPoint: {
            marker: {
              outline: { color: 'white' },
              fill: 'none',
              size: 28
            }
          },
          points: [{ id: 'value1', x: 0, y: value1 }]
        },
      ]
    });
  }

  function graficarSeries(seriesData) {
    var chart = JSC.chart('chartDivCitas', {
      debug: true,
      legend_visible: false,
      yAxis: {
        line_visible: false,
        defaultTick_enabled: false,
        scale: { range: [0, 100] }
      },
      defaultSeries_angle: {
        orientation: 90,
        sweep: 360,
        end: 360
      },
      defaultSeries: {
        type: 'gauge column roundcaps',
        /* angle: { sweep: 360, start: -90, end: 360 }, */
        defaultPoint_tooltip: '<b>%seriesName</b> %yValue% del total',
        shape: {
          innerSize: '70%',
          label: {
            text: '<b>%per %</b>',
            align: 'center',
            verticalAlign: 'middle'
          }
        }
      },
      series: seriesData
    });
  }

  function armarSeries(data) {
    let labels = data.labels;
    let porcentaje = data.porcentaje;
    let colors = data.colors;
    let midata = [];
    let p = 0;
    for (let i = 0; i < labels.length; i++) {
      p = porcentaje[i];
      midata.push(
        {
          color: colors[i],
          name: labels[i],
          attributes: {
            per: p
          },
          points: [['val', p]]
        },
      );
    }
    return midata;
  }

  function renderTiempoEspera30(data) {
    var chart1, chart2;

    chart1 = generateGaugeChart1Widget('chartDiv1', {
      orientation: 'horizontal',
      title: 'Tiempo Medio',
      value: data.media,
      maxValue: 50,
      color: '#EF6C00',
      showPercent: false,
      icon: 'linear/basic/clockwise'
    });
    chart2 = generateGaugeChart2Widget('chartDiv2', {
      orientation: 'horizontal',
      title: 'Desviación',
      value: data.desviacion,
      maxValue: 50,
      color: '#009688',
      showPercent: false,
      icon: 'linear/basic/mixer'
    });

    function generateGaugeChart1Widget(chartDiv, options) {
      return JSC.chart(chartDiv, {
        debug: true,
        legend_visible: false,
        annotations: [
          {
            label_text:
              wrapSpan('%sum', options.color, '28px', 'bold') + ' min<br>' + wrapSpan(options.title, '#9E9E9E', '14px'),
            position: options.orientation === 'vertical' ? 'top left' : 'right'
          }
        ],
        yAxis: {
          visible: false,
          formatString: options.formatValue,
          scale_range: [0, options.maxValue]
        },
        xAxis_defaultTick_gridLine: { color: '#ECEFF1', width: 4 },
        defaultSeries: {
          type: 'gauge column roundcaps',
          angle: { sweep: 360, start: -90 },
          mouseTracking_enabled: false,
          defaultPoint: {
            tooltip: '<b>%seriesName</b> %yValue% de la meta',
            altColor: 'currentColor',
            outline_width: 0
          },
          shape: {
            innerSize: '84%',
            label: [
              {
                text:
                  (options.icon
                    ? '<icon name=%icon size=' + (options.showPercent ? 20 : 40) + ' fill=%fill><br>'
                    : '') +
                  (options.showPercent
                    ? wrapSpan('{Math.round(%value*100/' + options.maxValue + ')}%', options.color, '20px', 'bold')
                    : ''),
                align: 'center',
                verticalAlign: 'middle'
              }
            ]
          }
        },
        series: [
          {
            color: options.color,
            name: options.title,
            attributes: {
              icon: options.icon,
              fill: options.color
            },
            points: [['val', options.value]]
          }
        ]
      });
    }

    function generateGaugeChart2Widget(chartDiv, options) {
      return JSC.chart(chartDiv, {
        debug: true,
        legend_visible: false,
        annotations: [
          {
            label: {
              text:
                wrapSpan('%sum', options.color, '28px', 'bold') + ' min<br>' + wrapSpan(options.title, '#9E9E9E', '14px')
            },
            position: options.orientation === 'vertical' ? 'top left' : 'right'
          }
        ],
        yAxis: {
          visible: false,
          formatString: options.formatValue,
          scale_range: [0, options.maxValue]
        },
        xAxis_defaultTick_gridLine: { color: options.color, opacity: 0.4 },
        defaultSeries: {
          type: 'gauge column roundcaps',
          angle: { sweep: 360, start: -90 },
          mouseTracking_enabled: false,
          defaultPoint: {
            tooltip: '<b>%seriesName</b> %yValue% of Goal',
            altColor: 'currentColor',
            outline_width: 0
          },
          shape: {
            innerSize: '84%',
            label: [
              {
                text:
                  (options.icon
                    ? '<icon name=%icon size=' + (options.showPercent ? 20 : 40) + ' fill=%fill><br>'
                    : '') +
                  (options.showPercent
                    ? wrapSpan('{Math.round(%value*100/' + options.maxValue + ')}%', options.color, '20px', 'bold')
                    : ''),
                align: 'center',
                verticalAlign: 'middle'
              }
            ]
          }
        },
        series: [
          {
            color: options.color,
            name: options.title,
            attributes: {
              icon: options.icon,
              fill: options.color
            },
            points: [['val', options.value]]
          }
        ]
      });
    }


    function wrapSpan(txt, color, fontSize, fontWeight) {
      var attributes = '';
      color && (attributes += 'color:' + color + ';');
      fontSize && (attributes += 'font-size:' + fontSize + ';');
      fontWeight && (attributes += 'font-weight:' + fontWeight + ';');
      attributes.length && (attributes = ' style="' + attributes + '"');
      return '<span' + attributes + '>' + txt + '</span>';
    }

  }

  function renderTiempoEspera60(data) {
    var chart1, chart2;

    chart1 = generateGaugeChart1Widget('chartDiv3', {
      orientation: 'horizontal',
      title: 'Tiempo Medio',
      value: data.media,
      maxValue: 50,
      color: '#EF6C00',
      showPercent: false,
      icon: 'linear/basic/clockwise'
    });
    chart2 = generateGaugeChart2Widget('chartDiv4', {
      orientation: 'horizontal',
      title: 'Desviación',
      value: data.desviacion,
      maxValue: 50,
      color: '#009688',
      showPercent: false,
      icon: 'linear/basic/mixer'
    });

    function generateGaugeChart1Widget(chartDiv, options) {
      return JSC.chart(chartDiv, {
        debug: true,
        legend_visible: false,
        annotations: [
          {
            label_text:
              wrapSpan('%sum', options.color, '28px', 'bold') + ' min<br>' + wrapSpan(options.title, '#9E9E9E', '14px'),
            position: options.orientation === 'vertical' ? 'top left' : 'right'
          }
        ],
        yAxis: {
          visible: false,
          formatString: options.formatValue,
          scale_range: [0, options.maxValue]
        },
        xAxis_defaultTick_gridLine: { color: '#ECEFF1', width: 4 },
        defaultSeries: {
          type: 'gauge column roundcaps',
          angle: { sweep: 360, start: -90 },
          mouseTracking_enabled: false,
          defaultPoint: {
            tooltip: '<b>%seriesName</b> %yValue% de la meta',
            altColor: 'currentColor',
            outline_width: 0
          },
          shape: {
            innerSize: '84%',
            label: [
              {
                text:
                  (options.icon
                    ? '<icon name=%icon size=' + (options.showPercent ? 20 : 40) + ' fill=%fill><br>'
                    : '') +
                  (options.showPercent
                    ? wrapSpan('{Math.round(%value*100/' + options.maxValue + ')}%', options.color, '20px', 'bold')
                    : ''),
                align: 'center',
                verticalAlign: 'middle'
              }
            ]
          }
        },
        series: [
          {
            color: options.color,
            name: options.title,
            attributes: {
              icon: options.icon,
              fill: options.color
            },
            points: [['val', options.value]]
          }
        ]
      });
    }

    function generateGaugeChart2Widget(chartDiv, options) {
      return JSC.chart(chartDiv, {
        debug: true,
        legend_visible: false,
        annotations: [
          {
            label: {
              text:
                wrapSpan('%sum', options.color, '28px', 'bold') + ' min<br>' + wrapSpan(options.title, '#9E9E9E', '14px')
            },
            position: options.orientation === 'vertical' ? 'top left' : 'right'
          }
        ],
        yAxis: {
          visible: false,
          formatString: options.formatValue,
          scale_range: [0, options.maxValue]
        },
        xAxis_defaultTick_gridLine: { color: options.color, opacity: 0.4 },
        defaultSeries: {
          type: 'gauge column roundcaps',
          angle: { sweep: 360, start: -90 },
          mouseTracking_enabled: false,
          defaultPoint: {
            tooltip: '<b>%seriesName</b> %yValue% of Goal',
            altColor: 'currentColor',
            outline_width: 0
          },
          shape: {
            innerSize: '84%',
            label: [
              {
                text:
                  (options.icon
                    ? '<icon name=%icon size=' + (options.showPercent ? 20 : 40) + ' fill=%fill><br>'
                    : '') +
                  (options.showPercent
                    ? wrapSpan('{Math.round(%value*100/' + options.maxValue + ')}%', options.color, '20px', 'bold')
                    : ''),
                align: 'center',
                verticalAlign: 'middle'
              }
            ]
          }
        },
        series: [
          {
            color: options.color,
            name: options.title,
            attributes: {
              icon: options.icon,
              fill: options.color
            },
            points: [['val', options.value]]
          }
        ]
      });
    }


    function wrapSpan(txt, color, fontSize, fontWeight) {
      var attributes = '';
      color && (attributes += 'color:' + color + ';');
      fontSize && (attributes += 'font-size:' + fontSize + ';');
      fontWeight && (attributes += 'font-weight:' + fontWeight + ';');
      attributes.length && (attributes = ' style="' + attributes + '"');
      return '<span' + attributes + '>' + txt + '</span>';
    }

  }

  function renderGraficoCampanias(data, id_canvas) {
    let p50 = Math.round(data.total * 0.5);
    let p75 = Math.round(data.total * 0.75);
    let aplicadas = 0;
    if (data.restante != 0) {
      aplicadas = data.total - data.restante;
    }
    var chartTem = JSC.chart(id_canvas, {
      debug: false,
      width: 200,
      defaultSeries_type: 'gauge linear vertical ',
      yAxis: {
        defaultTick_enabled: false,
        customTicks: [0, p50, p75, data.total],
        scale: { range: [0, data.total] },
        line: {
          width: 5,
          color: 'smartPalette',
          breaks_gap: 0.03
        }
      },
      legend_visible: false,
      palette: {
        pointValue: '%yValue',
        ranges: [
          { value: 0, color: '#FF5353' },
          { value: p50, color: '#FFD221' },
          { value: p75, color: '#77E6B4' },
          { value: [p75, data.total], color: '#21D683' }
        ]
      },
      defaultSeries: {
        defaultPoint_tooltip: '<b>Aplicadas:</b> %yValue',
        shape_label: {
          text: '%name',
          verticalAlign: 'bottom',
          style_fontSize: 14
        }
      },
      series: [
        { name: data.nombre, points: [['score', [0, aplicadas]]] },
      ]
    });
    //arrayTemp.push(chart);
    chartTem.redraw();
  }

  function filtrarData() {
    $('#btn-consulta').click(function () {
      let fecha_inicio = $('#fecha-inicio-r-m').val();
      let fecha_fin = $('#fecha-fin-r-m').val();

      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      if (fecha_inicio.length == 0) {
        Toast.fire({
          icon: 'info',
          title: 'Seleccione una fecha de inicio'
        })
      } else if (fecha_fin.length == 0) {
        Toast.fire({
          icon: 'info',
          title: 'Seleccione una fecha fin'
        })
      } else if (moment(fecha_inicio).isAfter(fecha_fin)) {
        Toast.fire({
          icon: 'info',
          title: 'La fecha fin no puede ser menor'
        })
      } else {
        $('#fecha-inicio-r-m2').text(fecha_inicio);
        $('#fecha-fin-r-m2').text(fecha_fin);

        $.ajax({
          // la URL para la petición
          url: urlServidor + 'citas/indicadoresGlobalesDate/' + fecha_inicio + '/' + fecha_fin,
          // especifica si será una petición POST o GET
          type: 'GET',
          // el tipo de información que se espera de respuesta
          dataType: 'json',
          success: function (response) {
            if (response.status) {
              positivo = response.data.satifaccionPaciente.positivo.csat_porcentaje;
              negativo = response.data.satifaccionPaciente.negativo.csat_porcentaje;
              $('#valPositivo').html(response.data.satifaccionPaciente.positivo.rango);
              $('#csatPositivo').html(response.data.satifaccionPaciente.positivo.csat_promedio);
              $('#valNegativo').html(response.data.satifaccionPaciente.negativo.rango);
              $('#csatNegativo').html(response.data.satifaccionPaciente.negativo.csat_promedio);
              dataSeries = response.data.estadosCitas.serie;
              let series = armarSeries(dataSeries);
              renderKpiSatisfaccion(positivo, negativo);
              graficarSeries(series);

              campanias = response.data.campanias;

              if (campanias.length > 0) {
                $('#msjNoInfo').html('');
                $('#box-canva1').empty();

                for (let i = 0; i < campanias.length; i++) {
                  const element = campanias[i];
                  let id_canvas = `chart-canvas-${i + 1}`;
                  let canvas = `<div id="${id_canvas}" class="ocultar" style="width:max-width: 250px;height: 400px;"></div>`;
                  $('#box-canva1').append(`<div class="col-md-4 col-sm-6">${canvas}</div>`); //'<div>hello</div>'

                  renderGraficoCampanias(element, id_canvas);
                }
              } else {
                $('#box-canva1').empty();
                $('#msjNoInfo').html('No existe Información de Campañas de Vacunación');
              }

              renderTiempoEspera30(response.data.timePaciente.time30);
              renderTiempoEspera60(response.data.timePaciente.time60);
            } else {
              Toast.fire({
                icon: 'info',
                title: 'No hay informacion disponible'
              })
              $('#tabla-reporte-data').addClass('d-none');
            }
          },
          error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
          },
          complete: function (jqXHR, status) {
            // console.log('Petición realizada');
          }
        });
      }
    });
  }
});

