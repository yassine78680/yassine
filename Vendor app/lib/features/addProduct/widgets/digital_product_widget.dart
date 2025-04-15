import 'dart:io';
import 'package:file_picker/file_picker.dart';
import 'package:flutter/material.dart';
import 'package:sixvalley_vendor_app/common/basewidgets/dropdown_decorator_widget.dart';
import 'package:sixvalley_vendor_app/features/product/domain/models/product_model.dart';
import 'package:sixvalley_vendor_app/localization/language_constrants.dart';
import 'package:sixvalley_vendor_app/features/addProduct/controllers/add_product_controller.dart';
import 'package:sixvalley_vendor_app/utill/dimensions.dart';
import 'package:sixvalley_vendor_app/utill/images.dart';
import 'package:sixvalley_vendor_app/utill/styles.dart';



class DigitalProductWidget extends StatefulWidget {
  final AddProductController? resProvider;
  final Product? product;
  final bool fromNextScreen;
  const DigitalProductWidget({Key? key, this.resProvider, this.product, this.fromNextScreen = false}) : super(key: key);

  @override
  State<DigitalProductWidget> createState() => _DigitalProductWidgetState();
}

class _DigitalProductWidgetState extends State<DigitalProductWidget> {
  PlatformFile? fileNamed;
  File? file;
  int?  fileSize;
  final List<String> itemList = ['physical', 'digital'];


  @override
  Widget build(BuildContext context) {

    return Column(children: [
      !widget.fromNextScreen ?
      Padding(
        padding: const EdgeInsets.symmetric(horizontal: Dimensions.paddingSizeMedium),
        child: DropdownDecoratorWidget(
            title: 'product_type',
            child: DropdownButton<String>(
              icon: const Icon(Icons.keyboard_arrow_down_outlined),
              borderRadius: const BorderRadius.all(Radius.circular(Dimensions.paddingEye)),
              value: widget.resProvider!.productTypeIndex == 0 ? 'physical' : 'digital',
              items: itemList.map((String value) {
                return DropdownMenuItem<String>(
                  value: value,
                  child: Text(getTranslated(value, context)!, style: robotoMedium),
                );
              }).toList(),
              onChanged: (value) {
                widget.resProvider!.setProductTypeIndex(value == 'physical' ? 0 : 1, true);
              },
              isExpanded: true,
              underline: const SizedBox(),
            )),
      ) : const SizedBox(),

      !widget.fromNextScreen ?
      SizedBox(height: widget.resProvider!.productTypeIndex == 1? Dimensions.paddingSizeSmall : 0) : const SizedBox(),


      widget.fromNextScreen && widget.resProvider!.productTypeIndex == 1 && widget.resProvider!.digitalProductTypeIndex == 1?
      Padding(
        padding: const EdgeInsets.fromLTRB(Dimensions.paddingSizeDefault, Dimensions.paddingSizeDefault, Dimensions.paddingSizeDefault, 0),
        child: Container(
          padding: const EdgeInsets.all(Dimensions.paddingSizeSmall),
          width: MediaQuery.of(context).size.width,
          decoration: BoxDecoration(
              color: Theme.of(context).cardColor,
              borderRadius: BorderRadius.circular(Dimensions.paddingSizeExtraSmall)
          ),
          child: InkWell(
            splashColor: Colors.transparent,
            onTap: () async {
              FilePickerResult? result = await FilePicker.platform.pickFiles(
                type: FileType.custom,
                allowedExtensions: ['pdf', 'zip', 'jpg', 'png', "jpeg", "gif"],
              );
              if (result != null) {
                file = File(result.files.single.path!);
                fileSize = await file!.length();
                fileNamed = result.files.first;
                widget.resProvider!.setSelectedFileName(file);

              }
            },
            child: Builder(
                builder: (context) {
                  return Column(mainAxisAlignment: MainAxisAlignment.center,crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      SizedBox(width: 50,child: Image.asset(Images.upload)),
                      widget.resProvider!.selectedFileForImport !=null ?
                      Text(fileNamed != null? fileNamed?.name??'':'${widget.product!.digitalFileReady}',maxLines: 2,overflow: TextOverflow.ellipsis):
                      Text(getTranslated('upload_file', context)!, style: robotoRegular.copyWith()),

                      widget.product !=null && fileNamed == null ?
                      Text(widget.product!.digitalFileReady??'', style: robotoRegular.copyWith()):const SizedBox(),

                    ],);
                }
            ),
          ),
        ),
      ):const SizedBox(),

      widget.fromNextScreen ?
      const SizedBox(height: Dimensions.paddingSizeDefault) : const SizedBox(),

    ]);
  }
}
